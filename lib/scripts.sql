create table lists (
  list_id int not null auto_increment,
  list_title varchar(250) not null,
  primary key (list_id)
  )engine = innodb;

create table list_items (
  item_id int not null auto_increment primary key,
  list_item varchar(250) not null,
  list_id int not null,
  index something (list_id),
  foreign key (list_id) references lists(list_id)
    on delete cascade
)engine=innodb;

insert into list_title 
  (list_title) values('the first title');

insert into list_items (list_item, list_id)
values ('something', 1);
  
