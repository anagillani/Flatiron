drop table if exists appuser;
create table appuser (
user_id int not null auto_increment,
-- login varchar(20) not null,
first_name varchar(20) not null,
last_name varchar(20) not null,
email varchar(50) not null,
pwd varchar(20) not null,
user_type enum('S','P','D'),
date_enrolled timestamp default current_timestamp,
primary key (user_id)
);


-- INSERT INTO appuser (`first_name`, `last_name`, `email`, `pwd`, `user_type`) VALUES ('lteitelman', '123456789', 'Lawrence', 'Teitelman', 'lawrence.teitelman@qc.cuny.edu', 'P');
-- INSERT INTO appuser (`first_name`, `last_name`, `email`, `pwd`, `user_type`) VALUES ('psmith', '987654321', 'Paula', 'Smith', 'paula.smith@qmail.cuny.edu', 'S');


drop table if exists questiontype;
create table questiontype (
code char(2) not null,
description varchar(20) not null,
primary key (code)
);

-- this line is needed for database to work
insert into questiontype values
('MC', 'Multiple Choice'),
('WA','Word Answer');

drop table if exists question;
create table question (
question_id int not null auto_increment,
title varchar(50) not null,
question_type char(2) not null,
content varchar(1000) not null,
answer varchar(100) not null,
last_modified timestamp default current_timestamp on update current_timestamp,
primary key (question_id),
foreign key (question_type) references questiontype (code)
);

-- INSERT INTO question (question_id,title,question_type,content,answer) VALUES (1,'Course Number','WA','What is the <b>number</b> of our course','355');
-- INSERT INTO question (question_id,title,question_type,content,answer) VALUES (2,'Gender','MC','What is the gender of President Trump?<a>Male<b>Female<c>Other','male');



drop table if exists questionset;
create table questionset (
questionset_id int not null auto_increment,
title varchar(50) not null,
primary key (questionset_id)
);
-- insert into questionset (title) values ('Review Questions #1');

drop table if exists questionset_question;
create table questionset_question (
questionset_id int not null,
question_id int not null,
points float not null,
primary key (questionset_id, question_id),
foreign key (questionset_id) references questionset(questionset_id),
foreign key (question_id) references question(question_id)
);
-- insert into questionset_question values (1,1,2.5);
-- insert into questionset_question values (1,2,1.3);


drop table if exists student_answers;
create table student_answers (
student_id int not null,
questionset_id int not null,
question_id int not null,
answer varchar(100) null,
primary key (student_id, questionset_id, question_id),
foreign key (student_id) references appuser(user_id),
foreign key (questionset_id) references questionset(questionset_id),
foreign key (question_id) references question(question_id)
);

-- insert into student_answers values (2, 1, 1, '323');
-- insert into student_answers values (2, 1, 2, 'male');

-- /* ANSWER SHOULD BE AROUND 1.3 */
select sum(points) 
from question q, questionset qs, questionset_question qsq, student_answers sa
where q.question_id = qsq.question_id
and sa.question_id = q.question_id
and qsq.questionset_id = qs.questionset_id
and qsq.questionset_id = sa.questionset_id
and sa.answer = q.answer;