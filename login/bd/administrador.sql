
create database sistemaap;

use sistemaap;

create table administrador(
				id int auto_increment,
				nombre varchar(50),
				apellido varchar(50),
				correo varchar(50),
				usuario varchar(50),
				password text(50),
				primary key(id)
					);