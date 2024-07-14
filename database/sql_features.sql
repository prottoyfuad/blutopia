
CREATE DATABASE Blutopia;
USE Blutopia;

CREATE TABLE User (
  username varchar(50) NOT NULL,
  userpass varchar(50) NOT NULL,
  first_name varchar(50) NOT NULL,
  last_name varchar(50) NOT NULL,
  email varchar(100) NOT NULL,
  birth_date date NOT NULL,
  created_on datetime NOT NULL,
  gender varchar(25) DEFAULT 'None',
  relationship varchar(25) DEFAULT 'None',
  primary_language varchar(25) DEFAULT 'English',
  interest varchar(25),
  lives_in varchar(100),
  studies_at varchar(100),
  works_at varchar(100),

  PRIMARY KEY (username),
  UNIQUE (email)
);

-- example ::

-- insert into user(username, userpass, first_name, last_name, email, birth_date, created_on)
-- VALUES ('prottoyfuad', '1234', 'Prottoy', 'Fuad', 'prottoy@gmail.com', '1998-08-29', '2022-01-26 05-35-55');

-- insert into user(username, userpass, first_name, last_name, email, birth_date, created_on)
-- VALUES ('spacekiddx', '4321', 'Space', 'Kid', 'spacekiddx@gmail.com', '1998-01-03', '2022-01-26 05-35-55');

CREATE TABLE Follow_event (
  src_name varchar(50) NOT NULL,
  trg_name varchar(50) NOT NULL,
  created_on datetime NOT NULL,

  FOREIGN KEY (src_name) REFERENCES User (username) ON DELETE CASCADE,
  FOREIGN KEY (trg_name) REFERENCES User (username) ON DELETE CASCADE,
  CONSTRAINT follow_event_id PRIMARY KEY (src_name, trg_name)
);

-- example ::

-- insert into Follow_event(src_name, trg_name, created_on)
-- VALUES('prottoyfuad', 'spacekiddx', '2022-01-26 05-38-55');

-- insert into Follow_event(src_name, trg_name, created_on)
-- VALUES('spacekiddx', 'prottoyfuad', '2022-01-26 05-38-55');

CREATE TABLE Tweet (  
  tweet_id bigint NOT NULL AUTO_INCREMENT,
  src_name varchar(50) NOT NULL,
  tweet varchar(240) NOT NULL,
  created_on datetime NOT NULL,

  FOREIGN KEY (src_name) REFERENCES User (username) ON DELETE CASCADE,
  PRIMARY KEY (tweet_id)
);

-- example ::

-- INSERT INTO Tweet(src_name, tweet, created_on) VALUES
-- ('prottoyfuad', "Hello world", '2019-12-1 11:12:12'),
-- ('spacekiddx', "Welcome to blutopia", '2019-12-1 11:12:13');

CREATE TABLE Reply (
  reply_id bigint NOT NULL AUTO_INCREMENT,
  tweet_id bigint NOT NULL,
  src_name varchar(50) NOT NULL,
  reply varchar(240) NOT NULL,
  created_on datetime NOT NULL,

  FOREIGN KEY (tweet_id) REFERENCES Tweet (tweet_id) ON DELETE CASCADE,
  FOREIGN KEY (src_name) REFERENCES User (username) ON DELETE CASCADE,
  PRIMARY KEY (reply_id)
);

CREATE TABLE Reaction (
  tweet_id bigint NOT NULL,
  src_name varchar(50) NOT NULL,
  vote tinyint NOT NULL,

  FOREIGN KEY (tweet_id) REFERENCES Tweet (tweet_id) ON DELETE CASCADE,
  FOREIGN KEY (src_name) REFERENCES User (username) ON DELETE CASCADE,
  CONSTRAINT reaction_id PRIMARY KEY (tweet_id, src_name)
);

Create TABLE Thread (
  thread_id bigint NOT NULL AUTO_INCREMENT,
  thread_name varchar(50) DEFAULT "New Conversation",
  created_on datetime NOT NULL,

  PRIMARY KEY (thread_id)
);

CREATE TABLE User_thread (
  thread_id bigint NOT NULL,
  src_name varchar(50) NOT NULL,
  created_on datetime NOT NULL,
  
  FOREIGN KEY (thread_id) REFERENCES Thread (thread_id) ON DELETE CASCADE,
  FOREIGN KEY (src_name) REFERENCES User (username) ON DELETE CASCADE,
  CONSTRAINT user_thread_id PRIMARY KEY (thread_id, src_name)
);

CREATE TABLE Msg_thread (
  msg_id bigint NOT NULL AUTO_INCREMENT,
  thread_id bigint NOT NULL,
  src_name varchar(50) NOT NULL,
  msg varchar(240) NOT NULL,
  created_on datetime NOT NULL,

  FOREIGN KEY (thread_id) REFERENCES Thread (thread_id) ON DELETE CASCADE,
  FOREIGN KEY (src_name) REFERENCES User (username) ON DELETE CASCADE,
  PRIMARY KEY (msg_id)
);

-- algorithms for Social Network database

-- finding tweet that should appear on specefic user's feed ::
SELECT * FROM Tweet WHERE src_name = ANY (
  SELECT trg_name FROM Follow_event WHERE src_name = 'username'
) ORDER BY created_on DESC;

-- finding reaction count for a specefic tweet
 SELECT count(*) FROM reaction WHERE tweet_id = 28;

-- finding upvote count
 SELECT count(*) FROM reaction WHERE tweet_id = 28 AND vote = 1;

 -- finding downvote count
 SELECT count(*) FROM reaction WHERE tweet_id = 28 AND vote = 0;

 -- finding someone's reaction in a tweet;
SELECT vote FROM reaction WHERE tweet_id = 28 AND src_name = 'prottoyfuad';

-- maintaining new upvote and downvotes

-- example :
-- insert into reaction(src_name, tweet_id, vote) VALUES
-- ('prottoyfuad', 28, 0),
-- ('spacekiddx', 28, 1);

-- insert into reaction(src_name, tweet_id, vote) VALUES
-- ('spacekiddx', 42, 1);

