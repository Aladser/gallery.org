-- таблица пользователей
create table users(
	user_login varchar(50) unique primary key,
	user_password varchar(50) not null,
	user_hash varchar(32) NOT NULL default '',
	user_ip int(10) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

create table images(
    id int AUTO_INCREMENT PRIMARY KEY,
	name varchar(50) UNIQUE
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
alter table images change name image_path varchar(255); 
alter table images change id image_id int auto_increment; 

CREATE table comments(
	id int auto_increment primary key,
	image_id int references images(id),
	cmt_date date,
	cmt_text text
);
alter table comments add column cmt_author varchar(50) references users(user_login);

-- удаление всех комментариев
delete from comments;