create table usuarios(
    id int auto_increment primary key,
    nombre varchar(50) not null,
    apellidos varchar(80) not null,
    email varchar(40) unique,
    provincia varchar(60) not null
);