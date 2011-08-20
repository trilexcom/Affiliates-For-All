-- Copyright (c) 2008, 2009 Metathinking Ltd.
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

drop table if exists countries cascade;
create table countries (
    id char(2) primary key,
    name text
);

create index countries_name on countries (name(10));

insert into countries (id, name) values ('af', 'Afghanistan');
insert into countries (id, name) values ('ax', 'Åland Islands');
insert into countries (id, name) values ('al', 'Albania');
insert into countries (id, name) values ('dz', 'Algeria');
insert into countries (id, name) values ('as', 'American Samoa');
insert into countries (id, name) values ('ad', 'Andorra');
insert into countries (id, name) values ('ao', 'Angola');
insert into countries (id, name) values ('ai', 'Anguilla');
insert into countries (id, name) values ('aq', 'Antarctica');
insert into countries (id, name) values ('ag', 'Antigua And Barbuda');
insert into countries (id, name) values ('ar', 'Argentina');
insert into countries (id, name) values ('am', 'Armenia');
insert into countries (id, name) values ('aw', 'Aruba');
insert into countries (id, name) values ('au', 'Australia');
insert into countries (id, name) values ('at', 'Austria');
insert into countries (id, name) values ('az', 'Azerbaijan');
insert into countries (id, name) values ('bs', 'Bahamas');
insert into countries (id, name) values ('bh', 'Bahrain');
insert into countries (id, name) values ('bd', 'Bangladesh');
insert into countries (id, name) values ('bb', 'Barbados');
insert into countries (id, name) values ('by', 'Belarus');
insert into countries (id, name) values ('be', 'Belgium');
insert into countries (id, name) values ('bz', 'Belize');
insert into countries (id, name) values ('bj', 'Benin');
insert into countries (id, name) values ('bm', 'Bermuda');
insert into countries (id, name) values ('bt', 'Bhutan');
insert into countries (id, name) values ('bo', 'Bolivia');
insert into countries (id, name) values ('ba', 'Bosnia And Herzegovina');
insert into countries (id, name) values ('bw', 'Botswana');
insert into countries (id, name) values ('bv', 'Bouvet Island');
insert into countries (id, name) values ('br', 'Brazil');
insert into countries (id, name) values ('io', 'British Indian Ocean Territory');
insert into countries (id, name) values ('bn', 'Brunei Darussalam');
insert into countries (id, name) values ('bg', 'Bulgaria');
insert into countries (id, name) values ('bf', 'Burkina Faso');
insert into countries (id, name) values ('bi', 'Burundi');
insert into countries (id, name) values ('kh', 'Cambodia');
insert into countries (id, name) values ('cm', 'Cameroon');
insert into countries (id, name) values ('ca', 'Canada');
insert into countries (id, name) values ('cv', 'Cape Verde');
insert into countries (id, name) values ('ky', 'Cayman Islands');
insert into countries (id, name) values ('cf', 'Central African Republic');
insert into countries (id, name) values ('td', 'Chad');
insert into countries (id, name) values ('cl', 'Chile');
insert into countries (id, name) values ('cn', 'China');
insert into countries (id, name) values ('cx', 'Christmas Island');
insert into countries (id, name) values ('cc', 'Cocos (Keeling) Islands');
insert into countries (id, name) values ('co', 'Colombia');
insert into countries (id, name) values ('km', 'Comoros');
insert into countries (id, name) values ('cg', 'Congo');
insert into countries (id, name) values ('cd',
    'Congo, The Democratic Republic Of The');
insert into countries (id, name) values ('ck', 'Cook Islands');
insert into countries (id, name) values ('cr', 'Costa Rica');
insert into countries (id, name) values ('ci', 'Côte D''Ivoire');
insert into countries (id, name) values ('hr', 'Croatia');
insert into countries (id, name) values ('cu', 'Cuba');
insert into countries (id, name) values ('cy', 'Cyprus');
insert into countries (id, name) values ('cz', 'Czech Republic');
insert into countries (id, name) values ('dk', 'Denmark');
insert into countries (id, name) values ('dj', 'Djibouti');
insert into countries (id, name) values ('dm', 'Dominica');
insert into countries (id, name) values ('do', 'Dominican Republic');
insert into countries (id, name) values ('ec', 'Ecuador');
insert into countries (id, name) values ('eg', 'Egypt');
insert into countries (id, name) values ('sv', 'El Salvador');
insert into countries (id, name) values ('gq', 'Equatorial Guinea');
insert into countries (id, name) values ('er', 'Eritrea');
insert into countries (id, name) values ('ee', 'Estonia');
insert into countries (id, name) values ('et', 'Ethiopia');
insert into countries (id, name) values ('fk', 'Falkland Islands (Malvinas)');
insert into countries (id, name) values ('fo', 'Faroe Islands');
insert into countries (id, name) values ('fj', 'Fiji');
insert into countries (id, name) values ('fi', 'Finland');
insert into countries (id, name) values ('fr', 'France');
insert into countries (id, name) values ('gf', 'French Guiana');
insert into countries (id, name) values ('pf', 'French Polynesia');
insert into countries (id, name) values ('tf', 'French Southern Territories');
insert into countries (id, name) values ('ga', 'Gabon');
insert into countries (id, name) values ('gm', 'Gambia');
insert into countries (id, name) values ('ge', 'Georgia');
insert into countries (id, name) values ('de', 'Germany');
insert into countries (id, name) values ('gh', 'Ghana');
insert into countries (id, name) values ('gi', 'Gibraltar');
insert into countries (id, name) values ('gr', 'Greece');
insert into countries (id, name) values ('gl', 'Greenland');
insert into countries (id, name) values ('gd', 'Grenada');
insert into countries (id, name) values ('gp', 'Guadeloupe');
insert into countries (id, name) values ('gu', 'Guam');
insert into countries (id, name) values ('gt', 'Guatemala');
insert into countries (id, name) values ('gg', 'Guernsey');
insert into countries (id, name) values ('gn', 'Guinea');
insert into countries (id, name) values ('gw', 'Guinea-Bissau');
insert into countries (id, name) values ('gy', 'Guyana');
insert into countries (id, name) values ('ht', 'Haiti');
insert into countries (id, name) values ('hm', 'Heard Island And Mcdonald Islands');
insert into countries (id, name) values ('va', 'Vatican City');
insert into countries (id, name) values ('hn', 'Honduras');
insert into countries (id, name) values ('hk', 'Hong Kong');
insert into countries (id, name) values ('hu', 'Hungary');
insert into countries (id, name) values ('is', 'Iceland');
insert into countries (id, name) values ('in', 'India');
insert into countries (id, name) values ('id', 'Indonesia');
insert into countries (id, name) values ('ir', 'Iran, Islamic Republic Of');
insert into countries (id, name) values ('iq', 'Iraq');
insert into countries (id, name) values ('ie', 'Ireland');
insert into countries (id, name) values ('im', 'Isle Of Man');
insert into countries (id, name) values ('il', 'Israel');
insert into countries (id, name) values ('it', 'Italy');
insert into countries (id, name) values ('jm', 'Jamaica');
insert into countries (id, name) values ('jp', 'Japan');
insert into countries (id, name) values ('je', 'Jersey');
insert into countries (id, name) values ('jo', 'Jordan');
insert into countries (id, name) values ('kz', 'Kazakhstan');
insert into countries (id, name) values ('ke', 'Kenya');
insert into countries (id, name) values ('ki', 'Kiribati');
insert into countries (id, name) values ('kp',
    'Korea, Democratic People''s Republic Of');
insert into countries (id, name) values ('kr', 'Korea, Republic Of');
insert into countries (id, name) values ('kw', 'Kuwait');
insert into countries (id, name) values ('kg', 'Kyrgyzstan');
insert into countries (id, name) values ('la',
    'Lao People''s Democratic Republic');
insert into countries (id, name) values ('lv', 'Latvia');
insert into countries (id, name) values ('lb', 'Lebanon');
insert into countries (id, name) values ('ls', 'Lesotho');
insert into countries (id, name) values ('lr', 'Liberia');
insert into countries (id, name) values ('ly', 'Libyan Arab Jamahiriya');
insert into countries (id, name) values ('li', 'Liechtenstein');
insert into countries (id, name) values ('lt', 'Lithuania');
insert into countries (id, name) values ('lu', 'Luxembourg');
insert into countries (id, name) values ('mo', 'Macao');
insert into countries (id, name) values ('mk', 'Macedonia');
insert into countries (id, name) values ('mg', 'Madagascar');
insert into countries (id, name) values ('mw', 'Malawi');
insert into countries (id, name) values ('my', 'Malaysia');
insert into countries (id, name) values ('mv', 'Maldives');
insert into countries (id, name) values ('ml', 'Mali');
insert into countries (id, name) values ('mt', 'Malta');
insert into countries (id, name) values ('mh', 'Marshall Islands');
insert into countries (id, name) values ('mq', 'Martinique');
insert into countries (id, name) values ('mr', 'Mauritania');
insert into countries (id, name) values ('mu', 'Mauritius');
insert into countries (id, name) values ('yt', 'Mayotte');
insert into countries (id, name) values ('mx', 'Mexico');
insert into countries (id, name) values ('fm', 'Micronesia, Federated States Of');
insert into countries (id, name) values ('md', 'Moldova, Republic Of');
insert into countries (id, name) values ('mc', 'Monaco');
insert into countries (id, name) values ('mn', 'Mongolia');
insert into countries (id, name) values ('me', 'Montenegro');
insert into countries (id, name) values ('ms', 'Montserrat');
insert into countries (id, name) values ('ma', 'Morocco');
insert into countries (id, name) values ('mz', 'Mozambique');
insert into countries (id, name) values ('mm', 'Myanmar');
insert into countries (id, name) values ('na', 'Namibia');
insert into countries (id, name) values ('nr', 'Nauru');
insert into countries (id, name) values ('np', 'Nepal');
insert into countries (id, name) values ('nl', 'Netherlands');
insert into countries (id, name) values ('an', 'Netherlands Antilles');
insert into countries (id, name) values ('nc', 'New Caledonia');
insert into countries (id, name) values ('nz', 'New Zealand');
insert into countries (id, name) values ('ni', 'Nicaragua');
insert into countries (id, name) values ('ne', 'Niger');
insert into countries (id, name) values ('ng', 'Nigeria');
insert into countries (id, name) values ('nu', 'Niue');
insert into countries (id, name) values ('nf', 'Norfolk Island');
insert into countries (id, name) values ('mp', 'Northern Mariana Islands');
insert into countries (id, name) values ('no', 'Norway');
insert into countries (id, name) values ('om', 'Oman');
insert into countries (id, name) values ('pk', 'Pakistan');
insert into countries (id, name) values ('pw', 'Palau');
insert into countries (id, name) values ('ps', 'Palestinian Territory, Occupied');
insert into countries (id, name) values ('pa', 'Panama');
insert into countries (id, name) values ('pg', 'Papua New Guinea');
insert into countries (id, name) values ('py', 'Paraguay');
insert into countries (id, name) values ('pe', 'Peru');
insert into countries (id, name) values ('ph', 'Philippines');
insert into countries (id, name) values ('pn', 'Pitcairn');
insert into countries (id, name) values ('pl', 'Poland');
insert into countries (id, name) values ('pt', 'Portugal');
insert into countries (id, name) values ('pr', 'Puerto Rico');
insert into countries (id, name) values ('qa', 'Qatar');
insert into countries (id, name) values ('re', 'Reunion');
insert into countries (id, name) values ('ro', 'Romania');
insert into countries (id, name) values ('ru', 'Russian Federation');
insert into countries (id, name) values ('rw', 'Rwanda');
insert into countries (id, name) values ('bl', 'Saint Barthélemy');
insert into countries (id, name) values ('sh', 'Saint Helena');
insert into countries (id, name) values ('kn', 'Saint Kitts And Nevis');
insert into countries (id, name) values ('lc', 'Saint Lucia');
insert into countries (id, name) values ('mf', 'Saint Martin');
insert into countries (id, name) values ('pm', 'Saint Pierre And Miquelon');
insert into countries (id, name) values ('vc', 'Saint Vincent And The Grenadines');
insert into countries (id, name) values ('ws', 'Samoa');
insert into countries (id, name) values ('sm', 'San Marino');
insert into countries (id, name) values ('st', 'Sao Tome And Principe');
insert into countries (id, name) values ('sa', 'Saudi Arabia');
insert into countries (id, name) values ('sn', 'Senegal');
insert into countries (id, name) values ('rs', 'Serbia');
insert into countries (id, name) values ('sc', 'Seychelles');
insert into countries (id, name) values ('sl', 'Sierra Leone');
insert into countries (id, name) values ('sg', 'Singapore');
insert into countries (id, name) values ('sk', 'Slovakia');
insert into countries (id, name) values ('si', 'Slovenia');
insert into countries (id, name) values ('sb', 'Solomon Islands');
insert into countries (id, name) values ('so', 'Somalia');
insert into countries (id, name) values ('za', 'South Africa');
insert into countries (id, name) values ('gs',
    'South Georgia And The South Sandwich Islands');
insert into countries (id, name) values ('es', 'Spain');
insert into countries (id, name) values ('lk', 'Sri Lanka');
insert into countries (id, name) values ('sd', 'Sudan');
insert into countries (id, name) values ('sr', 'Suriname');
insert into countries (id, name) values ('sj', 'Svalbard And Jan Mayen');
insert into countries (id, name) values ('sz', 'Swaziland');
insert into countries (id, name) values ('se', 'Sweden');
insert into countries (id, name) values ('ch', 'Switzerland');
insert into countries (id, name) values ('sy', 'Syrian Arab Republic');
insert into countries (id, name) values ('tw', 'Taiwan, Province Of China');
insert into countries (id, name) values ('tj', 'Tajikistan');
insert into countries (id, name) values ('tz', 'Tanzania, United Republic Of');
insert into countries (id, name) values ('th', 'Thailand');
insert into countries (id, name) values ('tl', 'Timor-Leste');
insert into countries (id, name) values ('tg', 'Togo');
insert into countries (id, name) values ('tk', 'Tokelau');
insert into countries (id, name) values ('to', 'Tonga');
insert into countries (id, name) values ('tt', 'Trinidad And Tobago');
insert into countries (id, name) values ('tn', 'Tunisia');
insert into countries (id, name) values ('tr', 'Turkey');
insert into countries (id, name) values ('tm', 'Turkmenistan');
insert into countries (id, name) values ('tc', 'Turks And Caicos Islands');
insert into countries (id, name) values ('tv', 'Tuvalu');
insert into countries (id, name) values ('ug', 'Uganda');
insert into countries (id, name) values ('ua', 'Ukraine');
insert into countries (id, name) values ('ae', 'United Arab Emirates');
insert into countries (id, name) values ('gb', 'United Kingdom');
insert into countries (id, name) values ('us', 'United States');
insert into countries (id, name) values ('um',
    'United States Minor Outlying Islands');
insert into countries (id, name) values ('uy', 'Uruguay');
insert into countries (id, name) values ('uz', 'Uzbekistan');
insert into countries (id, name) values ('vu', 'Vanuatu');
insert into countries (id, name) values ('ve', 'Venezuela');
insert into countries (id, name) values ('vn', 'Viet Nam');
insert into countries (id, name) values ('vg', 'Virgin Islands, British');
insert into countries (id, name) values ('vi', 'Virgin Islands, U.S.');
insert into countries (id, name) values ('wf', 'Wallis And Futuna');
insert into countries (id, name) values ('eh', 'Western Sahara');
insert into countries (id, name) values ('ye', 'Yemen');
insert into countries (id, name) values ('zm', 'Zambia');
insert into countries (id, name) values ('zw', 'Zimbabwe');

drop table if exists affiliates cascade;
create table affiliates (
    id integer primary key auto_increment,
    local_username varchar(20) not null unique,
    local_password text not null,
    title text,
    first_name text,
    last_name text,
    email text,
    email_update boolean not null default false,
    address1 text,
    address2 text,
    address3 text,
    address4 text,
    postcode text,
    country char(2) references countries (id)
        on update cascade on delete restrict,
    phone text,
    paypal text,
    default_commission boolean not null default true,
    commission_percent decimal(10, 2),
    commission_fixed decimal(10, 2),
    wizard_complete boolean not null default false,
    administrator boolean not null default false
);

insert into affiliates
    (local_username, local_password, wizard_complete, administrator)
values
    ('Admin', 'Admin', true, true);

drop table if exists order_status cascade;
create table order_status (
    id varchar(10) primary key
);

insert into order_status values ('new');
insert into order_status values ('cancelled');
insert into order_status values ('shipped');
insert into order_status values ('refunded');
insert into order_status values ('refund');

drop table if exists orders cascade;
create table orders (
    id text,
    affiliate integer not null,
    affiliate_data text,
    status varchar(10) not null,
    customer_email text,
    customer_name text,
    customer_id varchar(40),
    total decimal(10, 2) not null,
    commission decimal(10, 2) not null,
    date_entered timestamp not null default current_timestamp,

    primary key(id(20)),
    foreign key (affiliate) references affiliates (id)
        on update cascade on delete cascade,
    foreign key (status) references order_status (id)
        on update cascade on delete restrict
);

create index orders_affiliate_date_entered on orders (affiliate, date_entered);
create index orders_customer_id_date_entered
    on orders (customer_id, date_entered);

create or replace view daily_orders as
    select affiliate, date(date_entered) as date_entered, count(*) as count,
        sum(total) as total, sum(commission) as commission
    from orders where status in ('new', 'shipped')
    group by affiliate, date(date_entered);

create or replace view affiliate_totals as
    select affiliate, count(*) as count,
        sum(total) as total, sum(commission) as commission
    from orders where status in ('shipped', 'refunded', 'refund')
    group by affiliate;

drop table if exists payments cascade;
create table payments (
    id integer primary key auto_increment,
    affiliate integer not null,
    amount decimal(10, 2) not null,
    date_entered timestamp not null default current_timestamp,

    foreign key (affiliate) references affiliates (id)
        on update cascade on delete cascade
);

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
