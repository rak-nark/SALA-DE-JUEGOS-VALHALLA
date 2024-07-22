select a.codigoMascota, a.nombreMascota, a.edadMascota, b.nombreRaza, e.nombreDueno from mascota a, raza b, dueno e where  a.codigoRaza = b.codigoRaza and a.documentoDueno = e.documentoDueno;
create table venta(numeroVenta int not null primary key auto_increment,
fechaVenta date not null,
codigoCitas int(5) not null,
valorVenta float(10,0) not null,
ivaVenta Float(10,0) not null,
totalVenta float(10,0) not null,
foreign key(codigoCitas) references citas(codigoCitas)
);
select * from citas;
insert into venta values('','2024-07-19', 1, 60000, (valorVenta*0.19), (valorVenta+ivaVenta));
select * from venta;
delete from citas where codigoCitas in(2,3);
select * from dueno;
insert into citas values('', '2024-08-01', 1, 112421454, 1016594413);
select * from citas;
select * from mascota;
delete from citas where codigoCitas in (4,5,6);
insert into historiaClinica values('', '2024-07-19', 3, 1016594413);
select * from empleado;
select * from historiaClinica;
select * from venta;

insert into venta values ('', '2024-07-18', 7, 150000, (valorVenta*0.19), (valorVenta+ivaVenta));
insert into dueno values(1012365456, "cedula", "Andrea", "Martinez", "martand@gmail.com", "3012345433");
select * from dueno order by nombreDueno asc;
update dueno set nombreDueno = 'Maria', tipoDocumentoDueno = "tarjeta de identidad" where documentoDueno = '1012365456';

insert into raza values('', "shitzu");
select * from raza;
update raza set nombreRaza = "Greyhound" where codigoRaza = 4;
select sum(totalVenta) from venta;
select * from venta;

