create table Cinema
(
    id         int auto_increment
        primary key,
    name       varchar(255)                        not null,
    location   varchar(255)                        not null,
    phone      varchar(255)                        not null,
    created_at timestamp default CURRENT_TIMESTAMP null,
    updated_at timestamp default CURRENT_TIMESTAMP null on update CURRENT_TIMESTAMP
);

create table CO2Value
(
    id       int auto_increment
        primary key,
    cinemaId int                                 not null,
    value    int                                 not null,
    date     timestamp default CURRENT_TIMESTAMP null,
    constraint CO2Value_ibfk_1
        foreign key (cinemaId) references Cinema (id)
);

create index cinemaId
    on CO2Value (cinemaId);

create table DataUtil
(
    id    int auto_increment
        primary key,
    cle   varchar(255)   not null,
    texte varchar(16000) not null
);

create definer = avnadmin@`%` trigger DataUtil_after_delete
    after delete
on DataUtil
    for each row
begin
insert into log (log) values (concat('DataUtil deleted: ', old.cle, ' -> ', old.texte));
end;

create definer = avnadmin@`%` trigger DataUtil_after_insert
    after insert
    on DataUtil
    for each row
begin
insert into log (log) values (concat('DataUtil inserted: ', new.cle, ' -> ', new.texte));
end;

create definer = avnadmin@`%` trigger DataUtil_after_update
    after update
                     on DataUtil
                     for each row
begin
insert into log (log) values (concat('DataUtil updated: ', old.cle, ' -> ', new.cle, ' -> ', old.texte, ' -> ', new.texte));
end;

create table FAQ
(
    id         int auto_increment
        primary key,
    question   varchar(1024)                       not null,
    answer     varchar(1024)                       not null,
    created_at timestamp default CURRENT_TIMESTAMP null,
    updated_at timestamp default CURRENT_TIMESTAMP null on update CURRENT_TIMESTAMP
);

create definer = avnadmin@`%` trigger faq_after_delete
    after delete
on FAQ
    for each row
begin
insert into log (log) values (concat('FAQ deleted: ', old.question, ' -> ', old.answer));
end;

create definer = avnadmin@`%` trigger faq_after_insert
    after insert
    on FAQ
    for each row
begin
insert into log (log) values (concat('FAQ inserted: ', new.question, ' -> ', new.answer));
end;

create definer = avnadmin@`%` trigger faq_after_update
    after update
                     on FAQ
                     for each row
begin
insert into log (log) values (concat('FAQ updated: ', old.question, ' -> ', new.question, ' -> ', old.answer, ' -> ', new.answer));
end;

create table Role
(
    name varchar(255) not null
        primary key
);

create table SoundValue
(
    id       int auto_increment
        primary key,
    cinemaId int                                 not null,
    value    int                                 not null,
    date     timestamp default CURRENT_TIMESTAMP null,
    constraint SoundValue_ibfk_1
        foreign key (cinemaId) references Cinema (id)
);

create index cinemaId
    on SoundValue (cinemaId);

create table TempValue
(
    id       int auto_increment
        primary key,
    value    float                               not null,
    cinemaId int                                 not null,
    date     timestamp default CURRENT_TIMESTAMP null,
    constraint TempValue_ibfk_1
        foreign key (cinemaId) references Cinema (id)
);

create index cinemaId
    on TempValue (cinemaId);

create table User
(
    id         int auto_increment
        primary key,
    username   varchar(255)                           not null,
    firstName  varchar(255)                           not null,
    lastName   varchar(255)                           not null,
    email      varchar(255)                           not null,
    location   varchar(255)                           not null,
    phone      varchar(255)                           not null,
    password   varchar(255)                           not null,
    image      longblob                               null,
    role       varchar(255) default 'USER'            not null,
    created_at timestamp    default CURRENT_TIMESTAMP null,
    updated_at timestamp    default CURRENT_TIMESTAMP null on update CURRENT_TIMESTAMP,
    token      varchar(255)                           null,
    constraint fk_role
        foreign key (role) references Role (name)
);

create definer = avnadmin@`%` trigger user_preferences_trigger
    after insert
    on User
    for each row
begin
insert into UserPreferences (userId, acousticsTypeId, temperatureTypeId) values (new.id, 2, 2);
end;

create table acousticsType
(
    id         int auto_increment
        primary key,
    name       varchar(255)                        not null,
    created_at timestamp default CURRENT_TIMESTAMP null,
    updated_at timestamp default CURRENT_TIMESTAMP null on update CURRENT_TIMESTAMP
);

create table log
(
    id         int auto_increment
        primary key,
    log        varchar(15000)                      not null,
    created_at timestamp default CURRENT_TIMESTAMP null
);

create table temperatureType
(
    id         int auto_increment
        primary key,
    name       varchar(255)                        not null,
    created_at timestamp default CURRENT_TIMESTAMP null,
    updated_at timestamp default CURRENT_TIMESTAMP null on update CURRENT_TIMESTAMP
);

create table UserPreferences
(
    id                int auto_increment
        primary key,
    userId            int                                 not null,
    acousticsTypeId   int       default 2                 not null,
    temperatureTypeId int       default 2                 not null,
    created_at        timestamp default CURRENT_TIMESTAMP null,
    updated_at        timestamp default CURRENT_TIMESTAMP null on update CURRENT_TIMESTAMP,
    constraint UserPreferences_ibfk_1
        foreign key (userId) references User (id),
    constraint UserPreferences_ibfk_2
        foreign key (acousticsTypeId) references acousticsType (id),
    constraint UserPreferences_ibfk_3
        foreign key (temperatureTypeId) references temperatureType (id)
);

create index acousticsTypeId
    on UserPreferences (acousticsTypeId);

create index temperatureTypeId
    on UserPreferences (temperatureTypeId);

create index userId
    on UserPreferences (userId);

