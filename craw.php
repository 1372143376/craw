<?php
$craw = new craw();

//var_dump($craw->article());
var_dump($craw->index());
die;


//////////////////////////////
class craw
{

	//根路径
	private $baseDir = 'D:/test/page/';

	//图片目录
	private $img_Dir = 'D:/test/page/images/';

	//关键字
	private $key = '杰圣移民';

	//关键字搜索 专题页  加分页%u
	private $key_url = 'http://weixin.sogou.com/weixin?query=杰圣移民&_sug_type_=&s_from=input&_sug_=n&type=2&page=%u&ie=utf8';

	//分页
	private $start = 1;
	private $end = 10;

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


	//
	public function index()
	{
		//分页
		for ($i = $this->start;$i<=$this->end;$i++)
		{
			$cate_url = sprintf($this->key_url,$i);
			$this->category($cate_url);
		}
		//http://weixin.sogou.com/weixin?query=%E6%9D%B0%E5%9C%A3%E7%A7%BB%E6%B0%91&_sug_type_=&s_from=input&_sug_=n&type=2&page=5&ie=utf8
	}
	//专题
	public function category($cate_url)
	{
		//curl获取不到
		///^((ht|f)tps?):\/\/[\w\-]+(\.[\w\-]+)+([\w\-\.,@?^=%&:\/~\+#]*[\w\-\@?^=%&\/~\+#])?$/
		//$content = file_get_contents($this->key_url);
		$content = file_get_contents($cate_url);
		//return $content;
		//匹配文章链接http://mp.weixin.qq.com/s?
		///   /http:\/\/mp.weixin.qq.com\/s\?src=([\w\-]+(\.[\w\-]+)*\/)*[\w\-]+(\.[\w\-]+)*\/?(\?([\w\-\.,@?^=%&:\/~\+#]*)+)?/i
		preg_match_all('/href=\".*?\"/', $content, $data);
		if (empty($data[0]))
		{
			return [];
		}
		//return $data;
		$new_data =[];
		foreach ($data[0] as $k => $val)
		{
			//筛选
			if(strpos($val,'http://mp.weixin.qq.com/s?src=') === false)
			{
				continue;
			}
			//"href="http://mp.weixin.qq.com/s?src=3&amp;timestamp=1515926017&amp;ver=1&amp;signature=Zcr9FdALzIG3s1fDzbptLuFW6r*tauYy5LsWsijQ-9IqHX5zbBkGnnlDGw3-0maZX778L0gTJNnOLMetRLOcBWrL1ZCvXSdWsybH7EyULsVaRTPEdqs-bBOw9ip7RltDQIhSZWeEr4txBRvioZXN7A==""
			$val = str_replace('href="','',$val);
			//分析链接 有加盐  amp;
			$val = str_replace('amp;','',$val);
			//一维数组 文章的url
			$new_data[$k] =rtrim($val,'"');
		}
		$new_data = array_unique($new_data);
		foreach ($new_data as $article_url)
		{
			 $this->article($article_url);
		}

	}

	//文章页面，执行
	//param 文章的链接
	public function article($url)
	{

		//test下载页面
		//$file = $this->baseDir . 'html/' . rand(0,999) . '.html';
		//$this->down($file, $url);

		$content = $this->getUrlContent($url, 1);
		$content = $this->strr_replace($content);
		//return $content;die;
		//下载图片
		$img_url = $this->download_img($content);
		$result = $this->pdo->exec("insert into dede_article (body,is_down) values ('$img_url',1)");
		//爬过的文章
		echo 'success----  '.$url . "\n";
	}


//下载图片

	private function download_img($content)
	{
		//匹配有效图片地址
		preg_match_all('/((http|https):\/\/)+(\w+\.)+(.*)+(\w+)[\w\/\.\-\=]*(jpg|gif|png|jpeg)/i', $content, $data);
		if (empty($data))
		{
			return [];
		}
		//图片保存路径
		$img_Dir = $this->baseDir . 'images/';
		if (!file_exists($this->img_Dir))
		{
			mkdir($img_Dir, 0777, true);
		}

		foreach ($data[0] as $k => $v)
		{
			//$v图片的url   实例  =jpeg  =png
			if (strpos($v,'=') === false)
			{
				continue;
			}
			$filename = explode('=', $v);
			if (in_array($filename[1], $this->ext))
			{
				$current = file_get_contents($v);
				//新图片地址
				list($dst_filename, $new_filename) = $this->md5_filename(md5($filename[0]), $filename[1]);
				//替换原路径
				$content = str_replace($v, $new_filename, $content);
				//保存图片
				file_put_contents($dst_filename, $current);
			}
			continue;
		}
		return $content;
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
		$new_filename = '/images/' . $dir1 . '/' . $dir2 . '/' . $md5 . '.' . $ext;
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
		if ($type)
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
			$file1 = curl_exec($ch);
			//大部分切割
			$regex4 = "/<div id=\"js_article\".*?>.*?WindowsWechat/ism";
			if (preg_match($regex4, $file1, $file2))
			{
				preg_match('/<div id="js_article".*?>.*?<script/ism', $file2[0], $file);
				return $file;
			}
			else
			{
				return '0';
			}
			curl_close($ch);
		}
		else
		{
			ob_start();
			readfile($url);
			$file = ob_get_contents();
			ob_end_clean();
			return $file;
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


}








