-- Copyright (c) 2008 Metathinking Ltd.
--
-- This file is part of Affiliates For All.
--
-- Affiliates For All is free software: you can redistribute it and/or
-- modify it under the terms of the GNU General Public License as
-- published by the Free Software Foundation, either version 3 of the
-- License, or (at your option) any later version.
--
-- Affiliates For All is distributed in the hope that it will be useful,
-- but WITHOUT ANY WARRANTY; without even the implied warranty of
-- MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
-- General Public License for more details.
--
-- You should have received a copy of the GNU General Public License
-- along with Affiliates For All.  If not, see
-- <http://www.gnu.org/licenses/>.

set storage_engine = InnoDB;

drop table if exists affiliates cascade;
create table affiliates (
    id integer primary key auto_increment,
    local_username varchar(20) not null unique,
    local_password text not null
);

drop table if exists orders cascade;
create table orders (
    id text,
    affiliate integer not null,
    total decimal(10, 2) not null,
    commission decimal(10, 2) not null,
    date_entered timestamp not null default current_timestamp,

    primary key(id(20))
);

create index orders_affiliate on orders (affiliate);
