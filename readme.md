##documents
----
php爬虫  
爬网站的文章、标题、图片

只针对特定网站（微信搜狐）自己学习技术，不做商用

（http://weixin.sogou.com/weixin?query=%s&_sug_type_=&s_from=input&_sug_=n&type=2）

链接中第一个%是关键字、第二个是分页页数  用printf替换

- 首先，需要自建一个关键字的词表（id，name ，is_done）
- 注意属性中设置的一些绝对路径
- 注意用了php pdo连接mysql,一些表的命名等，都是写死的
- 如果出现null ， 说明得防爬虫的安全验证，需要每小时不能爬太多
- 发现30min爬100个页面，没问题

表

```
CREATE TABLE `star_cate` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `wx_code` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `is_done` tinyint(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4;


--------
CREATE TABLE `star_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `body` text NOT NULL,
  `img_md5` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

```

### 最新版本是craw_client.php代码

。。后期继续优化中。。。。

