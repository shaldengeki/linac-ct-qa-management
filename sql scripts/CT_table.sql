create table CT_admin(
admin_name varchar(50) NOT NULL,
admin_password varchar(50) NOT NULL,
primary key (admin_name)

);

create table CT_user(
user_name varchar(50) NOT NULL,
user_password varchar(50) NOT NULL,
primary key (user_name)
);

create table CT_monthly(
name varchar(50) NOT NULL,
month_number int NOT NULL, 
year_number int NOT NULL,
date TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
physicist_name varchar(50) NOT NULL,
status boolean,
cs1 float,
cs2 float,
cs3 float,
cs4 float,
cs5 float,
n1 float,
n2 float,
n3 float,
n4 float,
n5 float,
lp1 float,
lp2 float,
lp3 float,
lcd1 varchar(10),
ti1 varchar(10),
rd1 varchar(10),
spa1 float,
laser_localization varchar(10),
hcr1 float,
st1 varchar(10),
fu1 float,
fu2 float,
fu3 float,
fu4 float,
fu5 float,
noise1 float,
noise2 float,
noise3 float,
noise4 float,
noise5 float,
primary key (name,month_number,year_number)

);