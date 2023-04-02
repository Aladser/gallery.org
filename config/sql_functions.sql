-- таблица пользователей
create table users(
	user_login varchar(50) unique primary key,
	user_password varchar(50) not null,
	user_hash varchar(32) NOT NULL default '',
	user_ip int(10) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;