<?php
$craw = new craw();

var_dump($craw->run());
//var_dump($craw->echo_log());
die;


//////////////////////////////
class craw
{

	//根路径
	private $baseDir = 'D:/test/page/';

	//图片目录
	private $img_Dir = 'D:/test/page/uploads/';

	//关键字
	//private $key = '杰圣移民';

	//关键字搜索 专题页  加分页%u
	private $key_url = 'http://weixin.sogou.com/weixin?query=%s&_sug_type_=&s_from=input&_sug_=n&type=2&page=%u&ie=utf8';
	//private $main_url = 'http://weixin.sogou.com/weixin?query=%s&_sug_type_=&s_from=input&_sug_=n&type=2';

	//分页
	private $start = 1;
	private $end = 10;

	//专题的id
	private $id = 3;

	//图片后缀
	private $ext = [
		'jpg',
		'png',
		'jpeg',
		'gif'
	];

	private $pdo;

	//文章test
	//private $url = 'https://mp.weixin.qq.com/s?__biz=MjM5MTUzOTAxNQ==&mid=2653255939&idx=1&sn=d92408bcc065e47c96d0d4236caf68ba&chksm=bd65d32b8a125a3d3e28e4fe113e0406b24d167ebb1371bb4d5c9d7d4467e2193b4211b4c7a0&scene=21';

	public function __construct()
	{

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
	}

	public function run()
	{
		set_time_limit(0);
		if ($this->id > 39)
		{
			echo 'suc';
			die();
		}
		//run
		$results = $this->pdo->query("select * from dede_quanquan  where id=$this->id");
		$row = $results->fetch(PDO::FETCH_ASSOC);
		//sleep(rand(1,8));
		$this->index($row['name']);

	}

	//专题页面

	public function index($key)
	{
		//分页
		for ($i = $this->start; $i <= $this->end; $i++)
		{
			$cate_url = sprintf($this->key_url, $key, $i);
			$this->category($cate_url, $this->id);
		}
		//http://weixin.sogou.com/weixin?query=%E6%9D%B0%E5%9C%A3%E7%A7%BB%E6%B0%91&_sug_type_=&s_from=input&_sug_=n&type=2&page=5&ie=utf8
	}

	//专题
	public function category($cate_url, $cate_id)
	{
		//curl获取不到
		///^((ht|f)tps?):\/\/[\w\-]+(\.[\w\-]+)+([\w\-\.,@?^=%&:\/~\+#]*[\w\-\@?^=%&\/~\+#])?$/
		$content = $this->getUrlContent($cate_url, 2);
		/*var_dump($content);
		die;*/
		/*	if(is_null($content))
			{
				return $this->echo_log();
			}*/
		//$content = file_get_contents('D:\test\page\html\1.html');
		//匹配文章链接http://mp.weixin.qq.com/s?
		///   /http:\/\/mp.weixin.qq.com\/s\?src=([\w\-]+(\.[\w\-]+)*\/)*[\w\-]+(\.[\w\-]+)*\/?(\?([\w\-\.,@?^=%&:\/~\+#]*)+)?/i
		preg_match_all('/href=\".*?\"/', $content, $data);
		if (empty($data[0]))
		{
			return [];
		}
		$new_data = [];
		foreach ($data[0] as $k => $val)
		{
			//筛选
			if (strpos($val, 'http://mp.weixin.qq.com/s?src=') === false)
			{
				continue;
			}
			//"href="http://mp.weixin.qq.com/s?src=3&amp;timestamp=1515926017&amp;ver=1&amp;signature=Zcr9FdALzIG3s1fDzbptLuFW6r*tauYy5LsWsijQ-9IqHX5zbBkGnnlDGw3-0maZX778L0gTJNnOLMetRLOcBWrL1ZCvXSdWsybH7EyULsVaRTPEdqs-bBOw9ip7RltDQIhSZWeEr4txBRvioZXN7A==""
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
	//param 文章的链接  所属专题id
	public function article($url, $cate_id)
	{

		//test下载页面
		//$file = $this->baseDir . 'html/' . rand(0,999) . '.html';
		//$this->down($file, $url);

		$content = $this->getUrlContent($url, 1);
		$content = $this->strr_replace($content);
		//return $content;die;
		//下载图片 body local_img
		list($body, $local_img) = $this->download_img($content);
		//$body = preg_replace('/[img]htt.*?[/img]/','',$body);
		$title = explode('[/title]', $body)[0];
		$title = str_replace('[title]', '', $title);
		$title = str_replace('  ', '', $title);
		$title = str_replace('   ', '', $title);
		try
		{
			$result = $this->pdo->exec("insert into dede_article (cate_id,title,body,local_img) values ($cate_id,'$title','$body','$local_img')");
			$last_id = $this->pdo->lastInsertId();
			if ($last_id == (($this->id) * 100 - $this->id * 3))
			{
				$this->id = $this->id + 1;
				$this->run();
			}
		}
		catch (PDOException $e)
		{
			echo 'Connection failed: ' . $e->getMessage();
		}

		//爬过的文章
		echo 'success----  ' . $url . "\n";
	}


//下载图片

	private function download_img($content)
	{
		//匹配有效图片地址
		preg_match_all('/((http|https):\/\/)+(\w+\.)+(.*)+(\w+)[\w\/\.\-\=]*(jpg|gif|png|jpeg|\?)/i', $content, $data);
		//preg_match_all('/((http|https):\/\/)+(\w+\.)+(.*)+(\w+)[\w\/\.\-\=\?\d\W]*([\/img])$/i', $content, $data);
		if (empty($data))
		{
			return [];
		}
		//图片保存路径
		$img_Dir = $this->baseDir . 'uploads/';
		if (!file_exists($this->img_Dir))
		{
			mkdir($img_Dir, 0777, true);
		}

		//local_img 字段 json
		$local_img = [];
		foreach ($data[0] as $k => $v)
		{
			//$v图片的url   实例  =jpeg  =png
			/*	if (strpos($v, '=') === false)
				{
					continue;
				}*/
			//$v = str_replace('[/img]', '', $v);
			$filename = explode('=', $v);
			$current = file_get_contents($v);
			if (isset($filename[1]) && in_array($filename[1], $this->ext))
			{
				$ext = $filename[1];
			}
			else
			{
				$ext = 'jpg';
			}
			//新图片地址
			list($dst_filename, $new_filename) = $this->md5_filename(md5($v), $ext);
			//图片的字符串
			$local_img[] = $new_filename;
			//替换原路径
			$content = str_replace($v, $new_filename, $content);
			//保存图片
			file_put_contents($dst_filename, $current);
		}
		return [
			$content,
			json_encode($local_img)
		];
		///return $data;
	}

	//创建下载图片 目录
	//img param $md5  ext后缀           return  /4d/45/dasfsdfsd5f5ds.jpg
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
		$new_filename = '/uploads/' . $dir1 . '/' . $dir2 . '/' . $md5 . '.' . $ext;
		return [
			$dst_filename,
			$new_filename
		];
	}

	//过滤字符串
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
		//img
		$content = preg_replace('/<img[^>]+src="([^"]+)"[^>]*>/i', "\n[img]$1[/img]\n", $content);
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

	//测试下载html文件
	private function down($file, $url)
	{
		$html_url = $this->baseDir . 'html';
		//html保存路径
		if (!file_exists($html_url))
		{
			mkdir($html_url, 0777, true);
		}

		if (!file_exists($file))
		{
			$content = $this->getUrlContent($url);
			$len = mb_strlen($content);
			if ($len > 0)
			{
				file_put_contents($file, $content);
			}
			echo $file . "\n";
			echo sprintf("%s(%d)\n", $url, $len) . "\n";
		}

	}

	private function getUrlContent($url, $type = 1)
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
			$agent_id_array = ['104.224.176.239','47.91.226.157','104.224.176.239','104.224.176.239','155.94.228.241'];
			$agent_id_key =rand(0,4);
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
				'X-FORWARDED-FOR:'.$agent_id,
				'CLIENT-IP:'.$agent_id
			]);  //构造IP
			curl_setopt($ch, CURLOPT_REFERER, "http://www.baidu.com/");   //构造来路
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
			@curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1); // 使用自动跳转
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


	public function echo_log()
	{
		$id = $this->pdo->query("select id from dede_article order by id desc limit 1")->fetch(PDO::FETCH_ASSOC);
		return [
			'最后插入的id' => $id['id'],
			'属于的分类' => $this->id,
			'下次从多少页开始' => ceil($id['id'] / 10) + 1
		];
	}
}








