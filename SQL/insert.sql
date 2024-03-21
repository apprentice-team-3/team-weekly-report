CREATE TABLE users (
    id INT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    avatar_url VARCHAR(255),
    created_at TIMESTAMP
);
INSERT INTO users (id, name, email, password, avatar_url) VALUES
(1, 'YNSTakeru', 'ynstakeru@gmail.com', 'password', 'https://drive.google.com/file/d/1FXvhb0P416fJKwo-3_y8J3SmxDq65_kR/view?usp=sharing'),
(2, 'gintoki', 'gintoki@gmail.com', 'password', ''),
(3, 'ryumasann', 'ryuumasann@gmail.com', 'password', ''),
(4, 'Ryunosuke Matsuoka', 'ryuunosukematsuoka@gmail.com', 'password', '');
