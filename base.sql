drop database adoo;
create database adoo;
use adoo;

create table usuario(
	id int not null auto_increment,
	email varchar(30),
	password varchar(30),
	rol varchar(20),
	primary key(id)
);

create table consumidor(
	id int not null auto_increment,
	curp varchar(18),
	nombre varchar(45),
	appaterno varchar(45),
	apmaterno varchar(45),
	sexo varchar(6),
	fecha date,
	calle varchar(45),
	numext int,
	numint int,
	estado varchar(45),
	municipio varchar(45),
	colonia varchar(45),
	cp varchar(45),
	usuario_id int not null,
	primary key(id),
	foreign key(usuario_id) references usuario(id) on delete cascade on update cascade
);
