/**
@author evilnapsis
@brief Modelo de base de datos
**/
create database katanalite;
use katanalite;

create table user(
	id int not null auto_increment primary key,
	name varchar(50),
	lastname varchar(50),
	username varchar(50),
	email varchar(255),
	password varchar(60),
	is_active boolean default 1,
	is_admin boolean default 0,
	created_at datetime
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
	name varchar(200),
	short_name varchar(200),
	in_home boolean default 0,
	in_menu boolean default 0,
	is_active boolean default 0
);

insert into category (name,short_name,is_active) value ("Basico","basico",1);


create table product (
	id int not null auto_increment primary key,
	short_name varchar(20) ,
	name varchar(200) ,
	code varchar(200) ,
	description varchar(1000) ,
	offer_txt varchar(1000) ,
	image varchar(255),	
	link varchar(255),	
	is_featured boolean  default 0,
	is_public boolean  default 0,
	in_existence boolean  default 0,
	created_at datetime ,
	order_at datetime ,
	price float ,
	category_id int ,
	unit_id int ,
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
	name varchar(200),
	description varchar(1000),
	product_id int,
	val double,
	kind int default 1, /** 1.- precio, 2.- porcentaje **/
	is_multiple boolean default 0,
	is_active boolean default 1,
	start_at date,
	finish_at date,
	created_at datetime,
	foreign key(product_id) references product(id)
);


create table product_view(
	id int not null auto_increment primary key,
	viewer_id int,
	product_id int,
	created_at datetime,
	realip varchar(16),
	foreign key (viewer_id) references user(id),
	foreign key (product_id) references product(id)
);

create table client (
	id int not null auto_increment primary key,
	name varchar(50),
	lastname varchar(50),
	email varchar(255),
	phone varchar(255),
	address varchar(255),
	password varchar(60),
	is_active boolean default 1,
	created_at datetime
);

create table paymethod(
	id int not null auto_increment primary key,
	short_name varchar(100),
	name varchar(200),
	is_active boolean default 0	
);

insert into paymethod(short_name,name) value ("bank", "Deposito Bancario"),("deliver", "Pago Contra entrega");


create table status (
	id int not null auto_increment primary key,
	name varchar(200)
);

insert into status (name) value ("Pendiente");
insert into status (name) value ("Pagado");
insert into status (name) value ("Cancelado");
/* 3 estados extra*/
insert into status (name) value ("Enviado");
insert into status (name) value ("Finalizado");



create table buy (
	id int not null auto_increment primary key,
	k varchar(20),
	code varchar(20),
	client_id int,
	coupon_id int,
	status_id int,
	created_at datetime,
	paymethod_id int,
	foreign key(paymethod_id) references paymethod(id),
	foreign key(coupon_id) references coupon(id),
	foreign key(client_id) references client(id),
	foreign key(status_id) references status(id)
);

create table buy_product(
	id int not null auto_increment primary key,
	buy_id int,
	product_id int,
	q int,
	foreign key(buy_id) references buy(id),
	foreign key(product_id) references product(id)
);


create table slide (
	id int not null auto_increment primary key,
	title varchar(200),
	image varchar(255),	
	is_public boolean default 0,
	position int,
	created_at datetime
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
	label varchar(200),
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
