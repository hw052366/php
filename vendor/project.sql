-- 创建后台管理员表
create table admin(
	id int primary key auto_increment,
	username varchar(20) not null unique comment '用户名',
	password char(32) not null comment 'MD5双层加密',
	nickname varchar(20) comment '用户别名',
	email	varchar(50) not null comment '电子邮件',
	last_log_time int unsigned comment '上次登录时间',
	last_log_ip char(23) comment '上次登录IP地址'
)engine=innodb default charset utf8;

-- 插入用户
insert into admin values(null,'admin',md5(md5('admin')),'管理员','admin@blog.com',unix_timestamp(),'');

-- 创建分类表
create table category (
	id int primary key auto_increment,
	name varchar(50) not null comment '分类名称，可以同名，但是同一个分类下的子类不允许同名',
	nickname varchar(50) comment '分类别名',
	parent_id int unsigned not null default 0 comment '父分类ID，默认0表示顶级分类',
	sort int unsigned default 50 comment '分类排序，值越小排序越高'
)engine=innodb default charset utf8;

-- 插入数据
insert into category values
(null,'科技','',0,50), -- 1
(null,'武侠','',0,50), -- 2
(null,'旅游','',0,50), -- 3
(null,'美食','',0, 50), -- 4
(null,'IT','',1,50),   -- 5
(null,'生物','',1,50), -- 6
(null,'鸟类','',6,50), -- 7
(null,'湘菜','',4,50), -- 8
(null,'粤菜','',4,50), -- 9
(null,'川菜','',4,50), -- 10
(null,'跳跳蛙','',8,50), -- 11
(null,'口味虾','',8,50), -- 12
(null,'臭豆腐','',8,50), -- 13
(null,'白切鸡','',9,50), -- 14
(null,'隆江猪脚','',9,50); -- 15

-- 文章数据表
create table article(
	id int primary key auto_increment,
	title varchar(50) not null comment '文章标题',
	category_id int unsigned not null comment '文章所属分类',
	content text not null comment '文章内容', -- 超过255个长度的字符通常都用text

	author varchar(20) default '佚名' comment '作者',
	publish_time int unsigned comment '发表时间',
	status tinyint default 1 comment '文章状态：1代表草稿，0代表公开，2代表隐藏',
	top tinyint default 0 comment '是否置顶：1代表置顶，0代表普通'

	-- 如果说文章走审核流程：要么存在一个审核表，要么就在表中增加几个字段（审核记录）
)engine=innodb default charset utf8;

-- 插入文章
insert into article values
(null,'PHP是世界上最好的语言',5,'毫无疑问：顶',default,unix_timestamp(),1,1),
(null,'遍访湖湘美食',13,'长沙步行街南大门四娭毑臭豆腐，每天排队至少30人以上。','长沙晚报',unix_timestamp(),1,1);


-- 增加字段
alter table article add `read` int unsigned default 0;

-- 修改字段
-- alter table article modify author int unsigned;
-- 更新数据
update article set author = ceil(rand()*2) where id > 0;

-- 修改表结构
-- 修改表自身：表明，表选项（字符集，存储引擎等）
-- 修改表明
-- rename table 旧表名 to 新表名;
-- 修改表选项
-- alter table 表名 表选项 = 值; 
-- alter table new_test charset =gbk;

-- 修改表内部结构：字段（增删改）add,change（修改字段名）,modify（修改字段类型和属性），drop（删除）
-- 特别注意：增和改（add,modify和change）修改字段的时候字段必须后面要写完整（属性，类型）

-- change：alter table 表名 change 旧字段名 新字段名 字段类型 其他属性 位置[first/after 字段名字];
-- add：alter table 表名 add [column] 字段名 字段类型 其他属性 位置; 位置使用比较多
-- modify：alter table 表名 modify 已有字段名 新类型 新属性 新位置;
-- drop：alter table 表名 drop 字段名;

-- 枚举类型：属于字符串类型中的一种（单选），在一开始就给字段设定几个固定值，然后用户插入
-- 数据的时候，只能选择其中制定的几个
-- 字段名 enum(数据列表，用逗号隔开); 

-- alter table article modify status enum('草稿','公开','隐藏') default '公开' comment '文章状态：草稿作为第一个元素，有一个数值为1';
-- 草稿：1；公开：2；隐藏：3

-- 增加字段
alter table article add good int unsigned default 0 comment '赞';

-- 枚举字段本身存储的数据并不是字符串，而是数值
-- 枚举在默认查找字段的时候，读出来的数据永远是字符串，除非进行整形转换
-- 枚举意义：节省存储空间（实际存储数字），规范数据

-- 留言表
create table message(
	id int primary key auto_increment,
	content text not null comment '留言内容',
	time int unsigned comment '留言时间',
	parent_id int unsigned default 0 comment '上级留言ID，0表示顶级留言',
	article_id int unsigned not null comment '文章ID',
	user_id int unsigned not null comment '用户ID'
)engine=innodb default charset utf8;


