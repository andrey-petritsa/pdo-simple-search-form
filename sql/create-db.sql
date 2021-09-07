CREATE DATABASE inline_exam;
use inline_exam;

CREATE TABLE Posts
(
    postId int,
    userId int,
    title  varchar(100),
    body   varchar(255),
    PRIMARY KEY (postId)
);

CREATE TABLE Comments
(
    commentId int,
    postId int,
    name varchar(100),
    email varchar(255),
    body varchar(255),
    PRIMARY KEY (commentId),
    FOREIGN KEY (postId)
        REFERENCES Posts(postId)
        ON DELETE CASCADE
);