create table if not exists admins  (
    id int primary key AUTO_INCREMENT,
    username varchar(100) not null,
    password varchar(100) not null,
    email varchar(50) not null,
    gender varchar(25) not null,
    firstName varchar(50) not null,
    lastName varchar(100) not null
) engine=MyISAM  DEFAULT CHARSET=latin1;

CREATE TABLE if not exists authors (
    id int primary key AUTO_INCREMENT,
    name varchar(255) not null,
    date_birth varchar(10) not null,
    date_death varchar(10),
    authorAddedBy int not null,
    foreign key (authorAddedBy) references admins (id) on delete cascade
) engine=MyISAM DEFAULT CHARSET=latin1 ;

CREATE TABLE if not exists genres(
    id int primary key AUTO_INCREMENT,
    name varchar(50) not null,
    genreAddedBy int not null,
    foreign key (genreAddedBy) references admins (id) on delete cascade
) engine=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE if not exists book (
    id int primary key AUTO_INCREMENT,
    name varchar(50) not null,
    bookAddedBy int not null,
    authorId int not null,
    genreId int not null,
    foreign key (bookAddedBy) references admins (id) on delete cascade,
    foreign key (authorId) references authors (id) on delete cascade,
    foreign key (genreId) references genres (id) on delete cascade
) engine=MyISAM DEFAULT CHARSET=latin1;

insert into admins values (1, 'r1nce', 'password', 'jzxcvblessed@gmail.com', 'male', 'Zhanibek', 'Jumadiyev');

insert into authors values (1, 'Eiichiro Oda', '01.01.1975', 'alive', 1);
insert into authors values (2, 'Masashi Kishimoto', '08.11.1974', 'alive', 1);
insert into authors values (3, 'Hirohiko Araki', '07.06.1960', 'alive', 1);
insert into authors values (4, 'Takehiko Inoue', '12.01.1967', 'alive', 1);
insert into authors values (5, 'Kentaro Miura', '11.07.1966', '06.05.2021', 1);
insert into authors values (6, 'Yoshihiro Togashi', '27.04.1966', 'alive', 1);
insert into authors values (7, 'Naoko Takeuchi', '15.03.1967', 'alive', 1);
insert into authors values (8, 'Tite Kubo', '26.06.1977', 'alive', 1);

insert into genres values (1, 'detective', 1);
insert into genres values (2, 'fantasy', 1);
insert into genres values (3, 'action', 1);
insert into genres values (4, 'biography', 1);
insert into genres values (5, 'history', 1);
insert into genres values (6, 'manga', 1);
insert into genres values (7, 'comics', 1);

insert into book values (1, 'Bleach', 1, 8, 6);
insert into book values (2, 'Hunter x Hunter', 1, 6, 6);
insert into book values (3, 'One Piece', 1, 1, 6);
insert into book values (4, 'Naruto', 1, 2, 6);
insert into book values (5, "JoJo`s Bizzare Adventure", 1, 3, 6);
insert into book values (6, 'Slam Dunk', 1, 4, 6);
insert into book values (7, 'Berserk', 1, 5, 6);
insert into book values (8, 'Sailor Moon', 1, 7, 6);