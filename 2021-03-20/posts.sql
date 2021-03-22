# The assignment was to create a query that fetches the comments no older than 30 days and where written by the test@gmail.com user

CREATE TABLE `users` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `email` varchar(255) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY (`email`)
);

CREATE TABLE `posts` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` int(10) unsigned NOT NULL,
    `message` text NULL,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
);

INSERT INTO users(email) VALUES('test@gmail.com');
INSERT INTO posts(user_id, created_at) VALUES(1, '2021-03-01');

SELECT COUNT(*) AS postcount FROM posts 
INNER JOIN users ON users.id = posts.user_id
WHERE posts.created_at > NOW() - INTERVAL 30 DAY
AND users.email = 'test@gmail.com';

INDEX ON user_id