/**
@author evilnapsis
@brief Modelo de base de datos
**/
create database katana;
use katana;

create table user(
	id int not null auto_increment primary key,
	name varchar(50) not null,
	lastname varchar(50) not null,
	username varchar(50),
	email varchar(255) not null,
	password varchar(60) not null,
	is_active boolean not null default 1,
	is_admin boolean not null default 0,
	created_at datetime not null
);


insert into user(name,lastname,username,email,password,is_active,is_admin,created_at) value("Admin","","admin","",sha1(md5("admin")),1,1,NOW());


create table unit (
	id int not null auto_increment primary key,
	name varchar(200) not null
);

insert into unit (name) value ("Pieza");
insert into unit (name) value ("Kit");
insert into unit (name) value ("Juego");
insert into unit (name) value ("Caja");

create table category (
	id int not null auto_increment primary key,
	name varchar(200) not null,
	short_name varchar(200) not null,
	in_home boolean not null default 0,
	in_menu boolean not null default 0,
	is_active boolean not null default 0
);

insert into category (name) value ("Basico");


create table product (
	id int not null auto_increment primary key,
	short_name varchar(20) not null,
	name varchar(200) not null,
	code varchar(200) not null,
	description varchar(1000) not null,
	offer_txt varchar(1000) not null,
	image varchar(255),	
	link varchar(255),	
	is_featured boolean not null default 0,
	is_public boolean not null default 0,
	in_existence boolean not null default 0,
	created_at datetime not null,
	order_at datetime not null,
	price float not null,
	category_id int not null,
	unit_id int not null,
	foreign key(unit_id) references unit(id),
	foreign key(category_id) references category(id)
);

create table product_view(
	id int not null auto_increment primary key,
	viewer_id int,
	product_id int null,
	created_at datetime not null,
	realip varchar(16) not null,
	foreign key (viewer_id) references user(id),
	foreign key (product_id) references product(id)
);

create table client (
	id int not null auto_increment primary key,
	name varchar(50) not null,
	lastname varchar(50) not null,
	email varchar(255) not null,
	phone varchar(255) not null,
	address varchar(255) not null,
	password varchar(60) not null,
	is_active boolean not null default 1,
	created_at datetime not null
);


create table status (
	id int not null auto_increment primary key,
	name varchar(200) not null
);

insert into status (name) value ("Pendiente");
insert into status (name) value ("Pagado");
insert into status (name) value ("En Camino");
insert into status (name) value ("Entregado");
insert into status (name) value ("Cancelado");

create table buy (
	id int not null auto_increment primary key,
	code varchar(20) not null,
	client_id int not null,
	status_id int not null,
	created_at datetime not null,
	foreign key(client_id) references client(id),
	foreign key(status_id) references status(id)
);

create table buy_product(
	id int not null auto_increment primary key,
	buy_id int not null,
	product_id int not null,
	q int not null,
	foreign key(buy_id) references buy(id),
	foreign key(product_id) references product(id)

);

create table slide (
	id int not null auto_increment primary key,
	title varchar(200) not null,
	image varchar(255),	
	is_public boolean not null default 0,
	position int not null,
	created_at datetime not null
);
