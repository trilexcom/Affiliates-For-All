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
set foreign_key_checks = 0;

drop table if exists banners cascade;
create table banners (
    id integer primary key auto_increment,
    name varchar(40) not null unique,
    link_target text not null,
    enabled boolean not null default true,
    banner longblob not null,
    mime_type text not null
);

set foreign_key_checks = 1;
