create table comment (
id int not null auto_increment primary key,
content varchar(200) not null,
time int not null ,
user_id int not null,
article_id int not null,
parent_id int not null default 0
) engine=innodb default charset=utf8;