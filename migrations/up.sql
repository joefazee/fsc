CREATE TABLE companies (
    id int not null primary key auto_increment,
    name varchar(255) not null,
    address varchar(255) not null,
    created_at timestamp default now()
);

CREATE TABLE employees (
   id int not null primary key auto_increment,
   name varchar(255) not null,
   phone varchar(100) not null,
   email varchar(100) not null,
   company_id int not null,
   created_at timestamp default now()
);

