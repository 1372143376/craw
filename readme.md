##documents
----
php爬虫  
爬网站的文章、标题、图片

只针对特定网站（微信搜狐）
（http://weixin.sogou.com/weixin?query=%s&_sug_type_=&s_from=input&_sug_=n&type=2）

链接中第一个%是关键字、第二个是分页页数  用printf替换

- 首先，需要自建一个关键字的词表（id，name ，is_done）
- 注意属性中设置的一些绝对路径
- 注意用了php pdo连接mysql,一些表的命名等，都是写死的
- 如果出现null ， 说明得防爬虫的安全验证，需要每小时不能爬太多
- 发现30min爬100个页面，没问题


### 最新版本是craw_star.php代码

。。后期继续优化中。。。。

