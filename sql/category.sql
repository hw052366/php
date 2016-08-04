create table category (
id int primary key auto_increment,
sort int not null default 0,
name varchar(16) not null,
nickname varchar(16) not null default '',
parent_id int not null default 0
)engine=innodb default charset utf8;
CREATE TABLE `category` (
  `id` INT PRIMARY KEY auto_increment,
  `sort` INT NOT NULL DEFAULT 0,
  `name` varchar(16) NOT NULL,
  `nickname` varchar(16) NOT NULL DEFAULT '',
  `parent_id` INT NOT NULL DEFAULT 0
) ENGINE=INNODB DEFAULT CHARSET utf8;