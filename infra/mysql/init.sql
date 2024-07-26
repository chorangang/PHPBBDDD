CREATE TABLE Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE Threads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE
);

CREATE TABLE Comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    thread_id INT NOT NULL,
    body TEXT NOT NULL,
    upvotes INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (thread_id) REFERENCES Threads(id) ON DELETE CASCADE
);

-- Users テーブルにデータを挿入
INSERT INTO Users (name, email, password) VALUES
('User1', 'user1@example.com', 'P@ssword1'),
('User2', 'user2@example.com', 'P@ssword2'),
('User3', 'user3@example.com', 'P@ssword3'),
('User4', 'user4@example.com', 'P@ssword4'),
('User5', 'user5@example.com', 'P@ssword5'),
('User6', 'user6@example.com', 'P@ssword6'),
('User7', 'user7@example.com', 'P@ssword7'),
('User8', 'user8@example.com', 'P@ssword8'),
('User9', 'user9@example.com', 'P@ssword9'),
('User10', 'user10@example.com', 'P@ssword10');

-- Threads テーブルにデータを挿入
INSERT INTO Threads (user_id, title, body) VALUES
(1, 'Thread1 Title', 'Thread1 Body'),
(2, 'Thread2 Title', 'Thread2 Body'),
(3, 'Thread3 Title', 'Thread3 Body'),
(4, 'Thread4 Title', 'Thread4 Body'),
(5, 'Thread5 Title', 'Thread5 Body'),
(6, 'Thread6 Title', 'Thread6 Body'),
(7, 'Thread7 Title', 'Thread7 Body'),
(8, 'Thread8 Title', 'Thread8 Body'),
(9, 'Thread9 Title', 'Thread9 Body'),
(10, 'Thread10 Title', 'Thread10 Body');

-- Comments テーブルにデータを挿入
INSERT INTO Comments (user_id, thread_id, body) VALUES
(1, 1, 'Comment1 Body'),
(2, 2, 'Comment2 Body'),
(3, 3, 'Comment3 Body'),
(4, 4, 'Comment4 Body'),
(5, 5, 'Comment5 Body'),
(6, 6, 'Comment6 Body'),
(7, 7, 'Comment7 Body'),
(8, 8, 'Comment8 Body'),
(9, 9, 'Comment9 Body'),
(10, 10, 'Comment10 Body');
