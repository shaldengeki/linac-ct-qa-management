create table linac_image(
machine varchar(50) NOT NULL,
month int,
year int,
pathName varchar(100),
primary key(machine,month,year)

);
