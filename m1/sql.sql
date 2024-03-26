drop database team_weekly_report;

create database team_weekly_report character set 'utf8';
use team_weekly_report;

/*
progressは0~100で、100になったら完了とする
parent_tasksテーブルのprogressから集計する
 */

CREATE TABLE projects (
    id INT PRIMARY KEY,
    title VARCHAR(128) NOT NULL,
    content TEXT NOT NULL,
    progress FLOAT DEFAULT 0 NOT NULL,
    created_at TIMESTAMP
);

INSERT INTO projects (id, title, content, created_at) VALUES
(1, '僕らのプロジェクト', '僕らのプロジェクトの内容', concat( date_sub(current_date(), interval 120 day))),
(2, 'プロジェクト2', 'プロジェクト2の内容', concat( date_sub(current_date(), interval 120 day))),
(3, 'プロジェクト3', 'プロジェクト3の内容', concat( date_sub(current_date(), interval 120 day))),
(4, 'プロジェクト4', 'プロジェクト4の内容', concat( date_sub(current_date(), interval 120 day)));
