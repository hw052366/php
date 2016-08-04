create table article (
id int primary key auto_increment,
category_id int not null,
user_id int not null,
title varchar(30)  not null,
content text,
date int not null,
sttus tinyint   not nulldefault 2 int,
top tinyint  not null default 2
) engine=innodb  default charset utf8;