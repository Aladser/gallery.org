CREATE DATABASE galleryDB;
-- таблица пользователей
create table users(
	user_login varchar(50) unique primary key,
	user_password varchar(50) not null,
	user_hash varchar(32) NOT NULL default '',
	user_ip int(10) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
-- таблица изображений
create table images(
    id int AUTO_INCREMENT PRIMARY KEY,
	name varchar(50) UNIQUE
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
alter table images change name image_path varchar(255); 
alter table images change id image_id int auto_increment; 
-- таблица комментариев
CREATE table comments(
	id int auto_increment primary key,
	image_id int references images(id),
	cmt_date date,
	cmt_text text
);
alter table comments add column cmt_author varchar(50) references users(user_login);
alter table comments modify column cmt_date datetime;
-- роли пользователей
create table user_roles(
	id int auto_increment primary key,
	name varchar(30) not null
);
alter table user_roles add constraint uniq_name unique(name);
alter table users change role_id user_role_id int;
alter table users add constraint fk_role_id foreign key(user_role_id) references user_roles(id);
