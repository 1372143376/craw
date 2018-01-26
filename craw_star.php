<?php
set_time_limit(0);
$craw = new craw();
//$oo = $craw->category('D:\test\page\test\test.html', '', '');
//var_dump($oo);
//die;
echo 'success....all';
die;


//////////////////////////////
class craw
{

	//根路径
	private $baseDir = '/star/';

	//图片目录
	private $img_Dir = 'D:/test/page/star/';

	//页面类型，1 、img_md5 /// 保存单张图片 2、local_img ///json保存多张图片
	private $page_style = 1;

	//关键字搜索 专题页  加分页%u
	private $key_url = 'http://weixin.sogou.com/weixin?query=%s&_sug_type_=&s_from=input&_sug_=n&type=2&page=%u&ie=utf8';
	//private $main_url = 'http://weixin.sogou.com/weixin?query=%s&_sug_type_=&s_from=input&_sug_=n&type=2';

	//关键词表的起始id
	private $min_id = 1;
	//关键词表的结束id
	private $max_id = 81;

	/////////以下基本不需要修改
	//分页
	private $start = 1;
	private $end = 10;

	//专题的id //36
	private $id;

	//图片后缀
	private $ext = [
		'jpg',
		'png',
		'jpeg',
		'gif',
		'webp'
	];

	private $pdo;

	//文章test
	//private $url = 'https://mp.weixin.qq.com/s?__biz=MjM5MTUzOTAxNQ==&mid=2653255939&idx=1&sn=d92408bcc065e47c96d0d4236caf68ba&chksm=bd65d32b8a125a3d3e28e4fe113e0406b24d167ebb1371bb4d5c9d7d4467e2193b4211b4c7a0&scene=21';

	public function __construct()
	{
		set_time_limit(0);
		//链接数据库
		$db_user = "root";
		$db_pass = "";
		try
		{
			header("Content-Type: text/html; charset=utf-8");
			$dsn = 'mysql:dbname=test;host=127.0.0.1';
			$setting = array(
				PDO::ATTR_PERSISTENT => true,
				PDO::ATTR_ERRMODE => 2,
				PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
			);
			$this->pdo = new PDO($dsn, $db_user, $db_pass, $setting);
		}
		catch
		(PDOException $e)
		{
			echo $e->getMessage();
		}

		for ($id = $this->min_id; $id <= $this->max_id; $id++)
		{
			$results = $this->pdo->query("select * from star_cate  where id=$id and is_done = 0");
			$row = $results->fetch(PDO::FETCH_ASSOC);
			$this->pdo->exec("update star_cate set is_done = 1 where id = $id");
			if (empty($row))
			{
				continue;
			}
			else
			{
				print_r($this->echo_log());

				$this->id = $row['id'];
				$this->run($row['name']);
				//执行间隔的时间
				echo ' wait for 30 mins....';
				sleep(1800);
			}
		}

	}

	//启动

	/**
	 * @param $name string  搜索的关键字
	 */
	public function run($name)
	{
		set_time_limit(0);
		//run
		//分页
		for ($i = $this->start; $i <= $this->end; $i++)
		{
			$cate_url = sprintf($this->key_url, $name, $i);
			$this->category($cate_url, $this->id);
		}
	}

	//分析分页专题

	/**
	 * @param $cate_url string 专题页面链接
	 * @param $cate_id    int 关键词的分类id
	 * @return array
	 */
	public function category($cate_url, $cate_id)
	{
		$content = $this->getUrlContent($cate_url, 2);
		//打印ip是否被禁同了
		//var_dump($content);die;
		preg_match_all('/href=\".*?<img.*?<\/a>/', $content, $data);
		if (empty($data[0]))
		{
			return [];
		}

		if ($this->page_style == 1)
		{
			$this->page_style_1($data[0], $cate_id, $cate_url);
		}

		if ($this->page_style == 2)
		{
			$this->page_style_2($data[0], $cate_id, $cate_url);
		}

	}

	//针对不同页面,不同采集方式

	/**
	 * @param array $data 匹配的链接
	 * @param int $cate_id 关键词的分类id
	 * @param string $cate_url 专题页面的地址
	 */
	private function page_style_1($data, $cate_id, $cate_url)
	{
		$new_data = [];
		$herf = [];

		//排除三张首图的
		$n = 0;
		foreach ($data as $k => $val)
		{
			if (strpos($val, 'span') > 0)
			{
				$n++;
				if ($n > 1)
				{
					continue;
				}
			}
			else
			{
				$n = 0;
			}
			$new_data[$k] = $val;
		}

		foreach ($new_data as $k => $val)
		{
			//筛选
			if (strpos($val, 'http://mp.weixin.qq.com/s?src=') === false)
			{
				continue;
			}
			preg_match('/href=\".*?\"/', $val, $herf['a']);
			preg_match('/src=\".*?\"/', $val, $herf['img']);
			$herf['a'] = str_replace('href="', '', $herf['a']);
			//分析链接 有加盐  amp;
			$herf['a'] = str_replace('amp;', '', $herf['a']);
			$herf['a'] = rtrim($herf['a'][0], '"');
			//首图地址
			$herf['img'] = str_replace('src="', '', $herf['img']);
			//分析链接 有加盐  amp;
			$herf['img'] = str_replace('amp;', '', $herf['img']);
			$herf['img'] = rtrim($herf['img'][0], '"');

			$this->article($herf['a'], $cate_id, $herf['img'], $cate_url);
		}
	}

	/**
	 * @param array $data 匹配的链接
	 * @param int $cate_id 关键词的分类id
	 * @param string $cate_url 文章页面的地址
	 */
	private function page_style_2($data, $cate_id, $cate_url)
	{
		$new_data = [];
		foreach ($data as $k => $val)
		{
			//筛选
			if (strpos($val, 'http://mp.weixin.qq.com/s?src=') === false)
			{
				continue;
			}
			$val = str_replace('href="', '', $val);
			//分析链接 有加盐  amp;
			$val = str_replace('amp;', '', $val);
			//一维数组 文章的url
			$new_data[$k] = rtrim($val, '"');
		}
		$new_data = array_unique($new_data);

		foreach ($new_data as $article_url)
		{
			$this->article($article_url, $cate_id);
		}
	}
	//文章页面，执行

	/**
	 * @param string $url  文章链接
	 * @param int $cate_id  关键字的分类id
	 * @param string $img_url 分类页面单张图片
	 * @param string $cate_url 单张图片的链接
	 */
	public function article($url, $cate_id, $img_url = '', $cate_url = '')
	{

		$content = $this->getUrlContent($url, 1);
		$content = $this->strr_replace($content);
		if (empty($content))
		{

			return [];
		}
		//下载图片 body local_img
		list($body, $local_img) = $this->download_img($content, $url);
		//页面类型为1情况
		if ($this->page_style == 1)
		{
			$local_img = $this->download_one_img($img_url, $cate_url);
		}

		$title = explode('[/title]', $body)[0];
		$title = str_replace('[title]', '', $title);
		$title = str_replace('  ', '', $title);
		$title = str_replace('   ', '', $title);
		try
		{
			$this->pdo->exec("insert into star_article (cate_id,title,body,img_md5) values ($cate_id,'$title','$body','$local_img')");
		}
		catch (PDOException $e)
		{
			echo 'Connection failed: ' . $e->getMessage();
		}

		//爬过的文章
		echo 'success----  ' . $url;
	}


//下载文章页面图片

	private function download_img($content, $article_url)
	{
		//匹配有效图片地址
		preg_match_all('/((http|https):\/\/)+(\w+\.)+(.*)+(\w+)[\w\/\.\-\=\?]*(jpg|gif|png|jpeg|\d|\/|\\|\?)/i', $content, $data);
		//preg_match_all('/((http|https):\/\/)+(\w+\.)+(.*)+(\w+)[\w\/\.\-\=\?\d\W]*([\/img])$/i', $content, $data);
		if (empty($data))
		{
			return [];
		}
		//图片保存路径
		if (!file_exists($this->img_Dir))
		{
			mkdir($this->img_Dir, 0777, true);
		}
		//local_img 字段 json
		$local_img = [];
		foreach ($data[0] as $k => $v)
		{
			//获取图片后缀
			$ext = $this->get_img_ext($v);
			if (empty($ext))
			{
				continue;
			}
			$current = $this->getUrlContent($v, 2, $article_url);
			//新图片地址
			list($dst_filename, $new_filename) = $this->md5_filename(md5($v), $ext);
			//图片的字符串
			$local_img[] = $new_filename;
			//替换原路径
			$content = str_replace($v, $new_filename, $content);
			$content = str_replace('?[/img]','[/img]',$content);
			//保存图片
			file_put_contents($dst_filename, $current);
		}
		return [
			$content,
			json_encode($local_img)
		];
	}

	//专题页面，下载单张图片

	private function download_one_img($url, $category_url)
	{
		//获取图片后缀
		$ext = $this->get_img_ext($url);
		if (empty($ext))
		{
			$ext = 'jpeg';
		}
		//新图片地址
		list($dst_filename, $new_filename) = $this->md5_filename(md5($url), $ext);
		$current = $this->getUrlContent($url, 2, $category_url);
		//保存图片
		file_put_contents($dst_filename, $current);
		//返回单张图片新地址
		return $new_filename;
	}

	/**
	 * @param $url string 图片地址
	 * @return mixed string 后缀
	 */
	private function get_img_ext($url)
	{
		$ext = '';
		$header = get_headers($url, 1);
		if (empty($header))
		{
			$filename = explode('=', $url);
			if (isset($filename[1]) && in_array($filename[1], $this->ext))
			{
				$ext = $filename[1];
			}
		}
		else
		{
			$ext = explode('/', $header['Content-Type'])[1];
			if (!in_array($ext, $this->ext) || empty($ext))
			{
				$ext = '';
			}

		}
		return $ext;
	}

	//创建目录和下载图片

	/**
	 * @param $md5 string  图片名称
	 * @param $ext
	 * @return array
	 */
	private function md5_filename($md5, $ext)
	{
		$dir1 = $md5{0} . $md5{17};
		$dir2 = $md5{2} . $md5{8};
		$small_dir = $this->img_Dir . $dir1 . '/' . $dir2;
		if (!file_exists($this->img_Dir . $dir1))
		{
			mkdir($this->img_Dir . $dir1, 0777, true);
			if (!file_exists($small_dir))
			{
				mkdir($small_dir, 0777, true);
			}
		}
		else
		{
			if (!file_exists($small_dir))
			{
				mkdir($small_dir, 0777, true);
			}
		}
		$dst_filename = $small_dir . '/' . $md5 . '.' . $ext;
		//替换地址
		$new_filename = $this->baseDir . $dir1 . '/' . $dir2 . '/' . $md5 . '.' . $ext;
		return [
			$dst_filename,
			$new_filename
		];
	}

	//过滤字符串

	/**
	 * @param $content string 需要过滤的字符串
	 * @return mixed|string
	 */
	private function strr_replace($content)
	{
		$content = rtrim($content[0], '<script');
		$content = preg_replace('/<script[^>]*?>([\w\W]*?)<\/script>/i', "", $content);
		//$content = preg_replace('/<a[^>]+href="([^"]+)"[^>]*>(.*?)<\/a>/i', "[url=$1]$2[/url]", $content);
		//$content = preg_replace('/<font[^>]+color="(.*?)"[^>]*>(.*?)<\/font>/i', "[color=$1]$2[/color]", $content);
		//title
		$content = preg_replace('/<h2[^>]+([^"]+)[^h2>]*>/i', "\n[title]$1[/title]\n", $content);
		$content = preg_replace('/<\/h2/i', "", $content);
		//return $content;
		//meta
		$content = preg_replace('/meta_conten.*?rich_media_content/ism', "", $content);
		//推广
		$content = preg_replace('/阅读.*?/ism', "", $content);
		//img 注意文章图片的url
		$content = preg_replace('/<img[^>]+data-src="([^"]+)"[^>]*>/i', "\n[img]$1[/img]\n", $content);
		//return $content;
		$content = preg_replace('/<p[^>]*?>/i', "\n\n", $content);
		$content = preg_replace('/<([\/]?)b>/i', "[$1b]", $content);
		$content = preg_replace('/<([\/]?)strong>/i', "[$1b]", $content);
		$content = preg_replace('/<([\/]?)u>/i', "[$1u]", $content);
		$content = preg_replace('/<([\/]?)i>/i', "[$1i]", $content);
		$content = preg_replace('/&nbsp;/', " ", $content);
		$content = preg_replace('/&amp;/', "&", $content);
		$content = preg_replace('/&quot;/', "\"", $content);
		$content = preg_replace('/&lt;/', "<", $content);
		$content = preg_replace('/&gt;/', ">", $content);
		$content = preg_replace('/<br>/i', "\n", $content);
		$content = preg_replace('/<br\/>/i', "\n", $content);
		$content = preg_replace('/<br \/>/i', "\n", $content);
		$content = preg_replace('/<[^>]*?>/', "", $content);
		$content = preg_replace('/\[url=([^\]]+)\]\n(\[img\]\1\[\/img\])\n\[\/url\]/', "$2", $content);
		$content = preg_replace('/\n+/', "\n", $content);
		//去除空引用
		$content = str_replace('[quote][/quote]', '', $content);
		//去除空视频连接
		$content = preg_replace('/\[flash=\d+,\d+\]\[\/flash\]/', '', $content);
		$content = str_replace("\r\n", '', $content);
		$content = str_replace("[b]", '', $content);
		$content = str_replace("[/b]", '', $content);
		$content = str_replace("☼", '', $content);
		$content = str_replace(">", '', $content);
		$content = str_replace('	', '', $content);
		$content = str_replace('                ', '', $content);
		return $content;
	}


	//curl 下载

	/**
	 * @param $url    string 链接地址
	 * @param int $type 1、是栏目页面的分割  2、针对图片或文章的来路，百度未收录，从原文链接下载
	 * @param string $article_url 当type选择2,填写来路页面的链接
	 * @return mixed
	 */
	private function getUrlContent($url, $type = 1, $article_url = 'www.baidu.com')
	{
		if ($type == 1)
		{
			$ch = curl_init();
			$timeout = 5;
			curl_setopt($ch, CURLOPT_URL, $url);

			$header = $this->FormatHeader($url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);  //设置头信息的地方
			curl_setopt($ch, CURLOPT_HEADER, 0);    //不取得返回头信息
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//https,false参数是规避证书的检查
			//@curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1); // 使用自动跳转
			$file1 = curl_exec($ch);
			//大部分切割
			$regex4 = "/<div id=\"js_article\".*?>.*?WindowsWechat/ism";
			if (preg_match($regex4, $file1, $file2))
			{
				preg_match('/<div id="js_article".*?>.*?<script/ism', $file2[0], $file);
				curl_close($ch);
				return $file;
			}
			else
			{
				curl_close($ch);
				return '0';
			}

		}
		else
		{
			$agent_id_array = [
				'104.224.176.239',
				'47.91.226.157',
				'104.224.176.239',
				'104.224.176.239',
				'155.94.228.241'
			];
			$agent_id_key = rand(0, 4);
			$agent_id = $agent_id_array[$agent_id_key];
			$post = '';
			$autoFollow = 0;
			$ch = curl_init();
			$user_agent = 'Safari Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_1) AppleWebKit/537.73.11 (KHTML, like Gecko) Version/7.0.1 Safari/5
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent)';
			// 2. 设置选项，包括URL
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_HTTPHEADER, [
				'X-FORWARDED-FOR:' . $agent_id,
				'CLIENT-IP:' . $agent_id
			]);


			//针对图片的来路，百度未收录，得从原文链接下载
			curl_setopt($ch, CURLOPT_REFERER, $article_url);   //构造来路
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
			@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//https,false参数是规避证书的检查
			if ($autoFollow)
			{
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);  //启动跳转链接
				curl_setopt($ch, CURLOPT_AUTOREFERER, true);  //多级自动跳转
			}
			//
			if ($post != '')
			{
				curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
				curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			}
			// 3. 执行并获取HTML文档内容
			$output = curl_exec($ch);
			curl_close($ch);
			return $output;
		}
	}


	/**
	 * @param $url
	 * @param null $myIp
	 * @param null $xml
	 * @return array  分析header头
	 */
	private function FormatHeader($url, $myIp = null, $xml = null)
	{
		// 解悉url
		$temp = parse_url($url);
		$query = isset($temp['query']) ? $temp['query'] : '';
		$path = isset($temp['path']) ? $temp['path'] : '/';

		$header = array(
			"POST {$path}?{$query} HTTP/1.1",
			"Host: {$temp['host']}",
			'Accept: */*',
			"Referer: http://{$temp['host']}/",
			'User-Agent:Mozilla/5.0 (iPhone; CPU iPhone OS 7_0 like Mac OS X; en-us) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11A465 Safari/9537.53',
		);

		return $header;
	}

	/**
	 * @return array 返回上次爬完 ，插表的记录
	 */
	public function echo_log()
	{
		$id = $this->pdo->query("select id,cate_id from star_article order by id desc limit 1")->fetch(PDO::FETCH_ASSOC);
		return [
			'最一次插入的id' => $id['id'],
			'属于的分类' => $id['cate_id'],
		];
	}
}








