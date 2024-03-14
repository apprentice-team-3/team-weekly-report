-- 2回目以降コメントアウトして実行するとデバッグが楽になります
-- drop database team_weakly_report;

create database team_weakly_report;
use team_weakly_report;

/*
progressは0~100で、100になったら完了とする
tasksテーブルのprogressから集計する
 */
CREATE TABLE projects (
    id INT PRIMARY KEY,
    title VARCHAR(128) NOT NULL,
    content TEXT NOT NULL,
    progress INT DEFAULT 0 NOT NULL,
    created_at TIMESTAMP
);

CREATE TABLE users (
    id INT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    avatar_url VARCHAR(255),
    created_at TIMESTAMP
);

/*
statusを設定することで、お気に入りのタスクだったり、救難信号だったり、新着コメントのあるタスクを区別する
 */

CREATE TABLE tasks (
    user_id INT,
    id INT,
    project_id INT,
    date DATE NOT NULL,
    learning_time INT NOT NULL,
    title VARCHAR(128) NOT NULL,
    content TEXT,
    status VARCHAR(32) DEFAULT 'normal' NOT NULL,
    progress INT DEFAULT 0 NOT NULL,
    created_at TIMESTAMP,
    PRIMARY KEY (user_id, id),
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (project_id) REFERENCES projects (id)
);


/* scoreの範囲は5段階？ 1~5 */

CREATE TABLE comments (
    task_user_id INT,
    task_id INT,
    user_id INT,
    id INT,
    comment TEXT NOT NULL,
    score INT NOT NULL,
    created_at TIMESTAMP,
    PRIMARY KEY (task_user_id, task_id, user_id, id),
    FOREIGN KEY (task_user_id, task_id) REFERENCES tasks (user_id, id),
    FOREIGN KEY (user_id) REFERENCES users (id)
);

/*
    ユーザーがそのタスクを読んだか
    ユーザーがそのタスクにコメントしたか
    を管理するテーブル
 */

CREATE TABLE status_comments(
    user_id INT,
    task_user_id INT,
    task_id INT,
    comment_user_id INT,
    comment_id INT,
    isRead BOOLEAN DEFAULT FALSE,
    isCommented BOOLEAN DEFAULT FALSE,
    PRIMARY KEY (user_id, task_user_id, task_id, comment_user_id, comment_id),
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (task_user_id, task_id, comment_user_id, comment_id) REFERENCES comments (task_user_id, task_id, user_id, id)
);

