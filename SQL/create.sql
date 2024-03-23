-- 2回目以降コメントアウトして実行するとデバッグが楽になります
-- drop database team_weakly_report;

create database team_weakly_report;
use team_weakly_report;

/*
progressは0~100で、100になったら完了とする
parent_tasksテーブルのprogressから集計する
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
advanced
そのプロジェクトに誰が参加しているかを管理するテーブル
評価が完了したかを調べるために使う
今回はusersテーブルの総数でも代用できるためadvanced
 */
CREATE TABLE user_project (
    user_id INT,
    project_id INT,
    PRIMARY KEY (user_id, project_id),
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (project_id) REFERENCES projects (id)
);


/*
progressはchild_tasksのprogressから集計する
 */
CREATE TABLE parent_tasks (
    project_id INT,
    user_id INT,
    id INT,
    title VARCHAR(128) NOT NULL,
    progress INT DEFAULT 0 NOT NULL,
    created_at TIMESTAMP,
    PRIMARY KEY (project_id, user_id, id),
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (project_id) REFERENCES projects (id)
);

/*
contentにtaskの詳細を記入
 */
CREATE TABLE child_tasks (
    project_id INT,
    user_id INT,
    parent_task_id INT,
    title VARCHAR(128) NOT NULL,
    content TEXT,
    progress INT DEFAULT 0 NOT NULL,
    created_at TIMESTAMP,
    PRIMARY KEY (project_id, user_id, parent_task_id, id),
    FOREIGN KEY (project_id, user_id, parent_task_id) REFERENCES parent_tasks (project_id, user_id, id)
);

/*
statusテーブル name候補
normal
danger
completed
pending : 評価待ち
evaluated
 */

CREATE TABLE status(
    id INT PRIMARY KEY,
    name VARCHAR(128) NOT NULL,
    created_at TIMESTAMP
);

CREATE TABLE task_status (
    project_id INT,
    user_id INT,
    task_id INT,
    status_id INT,
    isStatus BOOLEAN DEFAULT FALSE,
    primary key (project_id, user_id, task_id, status_id),
    FOREIGN KEY (project_id, user_id, task_id) REFERENCES child_tasks (project_id, user_id, parent_task_id, id),
    FOREIGN KEY (status_id) REFERENCES status (id)
);


/*
メンバーのタスク評価項目を全て完了するとevaluationsテーブルに1行追加する
ユーザーの総数を取得し
evaluationsテーブルを使って、タスクの評価が完了したユーザーの総数を取得する
evaluations評価が完了すると、isEvaluationをTRUEにする

evaluationsテーブルのisEvaluationがTRUEにする条件
メンバー全員が評価を完了した場合
 */

CREATE TABLE evaluations(
    project_id INT,
    task_user_id INT,
    task_id INT,
    user_id INT,
    isEvaluated BOOLEAN DEFAULT FALSE,
    comment VARCHAR(255),
    created_at TIMESTAMP,
    PRIMARY KEY (project_id, task_user_id, task_id, user_id),
    FOREIGN KEY (project_id, user_id, task_id) REFERENCES child_tasks (project_id, user_id, parent_task_id, id),
    FOREIGN KEY (user_id) REFERENCES users (id)
);

/*
 name候補
 コードの綺麗さ
 実装難易度
 チーム貢献度
 報告のわかりやすさ
 実装速度

 フロント
 バック
 データベース
 要件定義
 WEBデザイン
 */

CREATE TABLE tags (
    id INT PRIMARY KEY,
    name VARCHAR(128) NOT NULL,
    created_at TIMESTAMP
);

/*
evaluation_tagsテーブルを使って、評価して欲しいタスクを設定する

 */
CREATE TABLE evaluation_tags(
    project_id INT,
    task_user_id INT,
    task_id INT,
    tag_name_id INT,
    PRIMARY KEY (project_id, task_user_id, task_id, tag_name_id),
    FOREIGN KEY (project_id, user_id, task_id) REFERENCES child_tasks (project_id, user_id, parent_task_id, id),
    FOREIGN KEY (tag_name_id) REFERENCES tags(id)
);

/*
advanced 子タスクへのコメント
 */

CREATE TABLE comments (
    project_id INT,
    task_user_id INT,
    task_id INT,
    user_id INT,
    comment TEXT NOT NULL,
    created_at TIMESTAMP,
    PRIMARY KEY (project_id, task_user_id, task_id, user_id),
    FOREIGN KEY (project_id, task_user_id, task_id) REFERENCES parent_tasks (project_id, user_id, id),
    FOREIGN KEY (user_id) REFERENCES users (id)
);

/*
    ユーザーがそのタスクを読んだか
    ユーザーがそのタスクにコメントしたか
    を管理するテーブル
 */

/*

ユーザーがタスク詳細画面に訪れたか
commentしたユーザーがいてかつ,isReadがFALSEの場合のみ

user_idはそのタスク詳細画面に訪れたユーザー
 */

CREATE TABLE is_read_comment(
    project_id INT,
    task_user_id INT,
    task_id INT,
    comment_user_id INT,
    user_id INT,
    isRead BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP,
    PRIMARY KEY (project_id, task_user_id, task_id, comment_user_id, user_id),
    FOREIGN KEY (project_id, task_user_id, task_id, comment_user_id) REFERENCES comments (project_id, task_user_id, task_id, user_id),
    FOREIGN KEY (user_id) REFERENCES users (id)
);
