create schema chatapp;
use chatapp;
CREATE TABLE users (
  user_id INT PRIMARY KEY auto_increment,
  username VARCHAR(50) NOT NULL,
  email VARCHAR(100) NOT NULL,
  date_of_birth date,
  user_password VARCHAR(100) NOT NULL,
  profile_picture longblob,
  type varchar(50),
  phone numeric,
  location varchar(100),
  work varchar(100),
  quot varchar(400),
  status VARCHAR(50)
);

CREATE TABLE conversations (
  conversation_id INT PRIMARY KEY auto_increment,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE user_conversations (
  sender_id INT not null,
  reciever_id INT not null,
  conversation_id INT not null,
  PRIMARY KEY (sender_id,reciever_id, conversation_id) 
);
CREATE TABLE messages (
  message_id INT PRIMARY KEY auto_increment,
  sender_id INT not null,
  reciever_id INT not null,
  conversation_id INT not null,
  content varchar(1000) not null,
  sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

select * from users;
select * from messages;
select * from user_conversations;
select * from conversations;
