/**
@author evilnapsis
@brief Modelo de base de datos
**/
create database katanalite;
use katanalite;

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

create table country (
	id int not null auto_increment primary key,
	name varchar(200) not null
);

insert into country (name) value ("Argentina");
insert into country (name) value ("Chile");
insert into country (name) value ("Colombia");
insert into country (name) value ("España");
insert into country (name) value ("Mexico");


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

insert into category (name,is_active) value ("Basico",1);


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
	/** for SEO **/
	meta_title varchar(100),
	meta_description varchar(255),
	meta_keywords varchar(100),
	foreign key(unit_id) references unit(id),
	foreign key(category_id) references category(id)
);

/*create table product_image(
	id int not null auto_increment primary key,
	title varchar(200) not null,
	description varchar(1000) not null,
	image varchar(255),	
	image_id int not null,
	foreign key(image_id) references image(id)
);
*/

create table coupon (
	id int not null auto_increment primary key,
	name varchar(200) not null,
	description varchar(1000) not null,
	product_id int,
	val double,
	kind int not null default 1, /** 1.- precio, 2.- porcentaje **/
	is_multiple boolean not null default 0,
	is_active boolean not null default 1,
	start_at date not null,
	finish_at date not null,
	created_at datetime not null,
	foreign key(product_id) references product(id)
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

create table paymethod(
	id int not null auto_increment primary key,
	short_name varchar(100),
	name varchar(200) not null,
	is_active boolean not null default 0	
);

insert into paymethod(short_name,name) value ("bank", "Deposito Bancario"),("deliver", "Pago Contra entrega");


create table status (
	id int not null auto_increment primary key,
	name varchar(200) not null
);

insert into status (name) value ("Pendiente");
insert into status (name) value ("Pagado");
insert into status (name) value ("Cancelado");
/* 3 estados extra*/
insert into status (name) value ("Enviado");
insert into status (name) value ("Finalizado");



create table buy (
	id int not null auto_increment primary key,
	k varchar(20) not null,
	code varchar(20) not null,
	client_id int not null,
	coupon_id int,
	status_id int not null,
	created_at datetime not null,
	paymethod_id int not null,
	foreign key(paymethod_id) references paymethod(id),
	foreign key(coupon_id) references coupon(id),
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
/**
kind:
1- texto
2- entero
3- checkbox
4- reference
**/


create table configuration(
	id int not null auto_increment primary key,
	name varchar(100) not null unique,
	label varchar(200) not null,
	kind int,
	val text,
	cfg_id int default 1
);

insert into configuration(name,label,kind,val) value ("general_main_title","Titulo Principal",1,"KATANA LITE");
insert into configuration(name,label,kind,val) value ("general_main_email","Email Principal",1,"tuemail@tudominio.com");
insert into configuration(name,label,kind,val) value ("general_country","Pais",1,"MX");
insert into configuration(name,label,kind,val) value ("general_coin","Moneda",1,"$");
insert into configuration(name,label,kind,val) value ("general_iva_txt","Impuesto Texto",1,"I.V.A");
insert into configuration(name,label,kind,val) value ("general_iva","Impuesto IVA (%)",2,16);
insert into configuration(name,label,kind,val) value ("general_img_default","Imagen Default",1,"res/img/default.png");
/* for bank */
insert into configuration(name,label,kind,val) value ("bank_titular","Titular de la cuenta",1,"");
insert into configuration(name,label,kind,val) value ("bank_name","Nombre del Banco",1,"");
insert into configuration(name,label,kind,val) value ("bank_account","Numero de Cuenta",1,"");
insert into configuration(name,label,kind,val) value ("bank_card","Numero de Tarjeta",1,"");
