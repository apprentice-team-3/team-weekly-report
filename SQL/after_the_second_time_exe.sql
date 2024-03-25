-- 2回目以降コメントアウトして実行するとデバッグが楽になります
drop database team_weekly_report;

create database team_weekly_report character set 'utf8mb4';
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
    progress FLOAT DEFAULT 0 NOT NULL,
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
    id INT,
    title VARCHAR(128) NOT NULL,
    content TEXT,
    progress FLOAT DEFAULT 0 NOT NULL,
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
    parent_task_id INT,
    task_id INT,
    status_id INT,
    isStatus BOOLEAN DEFAULT FALSE,
    primary key (project_id, user_id, task_id, status_id),
    FOREIGN KEY (project_id, user_id, parent_task_id,task_id) REFERENCES child_tasks (project_id, user_id, parent_task_id, id),
    FOREIGN KEY (status_id) REFERENCES status (id)
);


/*
evaluationsテーブルはevaluation_tagsと紐付けるために使用
 */

CREATE TABLE evaluations(
    project_id INT,
    task_user_id INT,
    parent_task_id INT,
    task_id INT,
    user_id INT,
    created_at TIMESTAMP,
    PRIMARY KEY (project_id, task_user_id, parent_task_id, task_id, user_id),
    FOREIGN KEY (project_id, task_user_id, parent_task_id, task_id) REFERENCES child_tasks (project_id, user_id, parent_task_id, id),
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
    parent_task_id INT,
    task_id INT,
    user_id INT,
    tag_name_id INT,
    isEvaluated BOOLEAN DEFAULT FALSE,
    comment VARCHAR(255),
    PRIMARY KEY (project_id, task_user_id, parent_task_id, task_id, user_id, tag_name_id),
    FOREIGN KEY (project_id, task_user_id, parent_task_id, task_id, user_id) REFERENCES evaluations (project_id, task_user_id, parent_task_id, task_id, user_id),
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

INSERT INTO users (id, name, email, password, avatar_url) VALUES
(1, 'YNSTakeru', 'ynstakeru@gmail.com', 'password', 'https://drive.google.com/file/d/1FXvhb0P416fJKwo-3_y8J3SmxDq65_kR/view?usp=sharing'),
(2, 'gintoki', 'gintoki@gmail.com', 'password', ''),
(3, 'ryumasann', 'ryuumasann@gmail.com', 'password', ''),
(4, 'Ryunosuke Matsuoka', 'ryuunosukematsuoka@gmail.com', 'password', '');

-- 作成日時よりも120日前に作成する
INSERT INTO projects (id, title, content, created_at) VALUES
(1, '僕らのプロジェクト', '僕らのプロジェクトの内容', concat( date_sub(current_date(), interval 120 day))),
(2, 'プロジェクト2', 'プロジェクト2の内容', concat( date_sub(current_date(), interval 120 day))),
(3, 'プロジェクト3', 'プロジェクト3の内容', concat( date_sub(current_date(), interval 120 day))),
(4, 'プロジェクト4', 'プロジェクト4の内容', concat( date_sub(current_date(), interval 120 day)));

-- pending : 評価待ち、タスクの完了 = 評価待ち状態
INSERT INTO status (id, name) VALUES
(1, 'normal'),
(2, 'danger'),
(3, 'pending'),
(4, 'evaluated');

INSERT INTO tags (id, name) VALUES
(1, 'コードの綺麗さ'),
(2, '実装難易度'),
(3, 'チーム貢献度'),
(4, '報告のわかりやすさ'),
(5, '実装速度');

INSERT INTO parent_tasks (project_id, user_id, id, title, progress) VALUES
(1, 1, 1, 'ワイヤーフレームの作成', 0),
(1, 2, 2, '画面遷移図', 0),
(1, 3, 3, 'データベース設計', 0),
(1, 4, 4, 'タスク出し', 0),
(1, 1, 5, 'LPの作成', 0),
(1, 2, 6, 'コア機能実装', 0),
(1, 3, 7, 'データベース周りの実装', 0),
(1, 4, 8, 'ユーザー登録処理の実装', 0),
(1, 1, 9, 'aページの表示処理', 0),
(1, 2, 10, 'bページの表示処理', 0),
(1, 3, 11, 'cページの表示処理', 0),
(1, 4, 12, 'dページの表示処理', 0),
(1, 1, 13, 'aページのスタイルを整える', 0),
(1, 2, 14, 'bページのスタイルを整える', 0),
(1, 3, 15, 'cページのスタイルを整える', 0),
(1, 4, 16, 'dページのスタイルを整える', 0),
(1, 1, 17, 'aページの動的な画面処理', 0),
(1, 2, 18, 'bページの動的な画面処理', 0),
(1, 3, 19, 'cページの動的な画面処理', 0),
(1, 4, 20, 'dページの動的な画面処理', 0);

INSERT INTO child_tasks (project_id, user_id, parent_task_id, id, title, content, progress) VALUES
(1, 1, 1, 1, '画面1のワイヤーフレーム作成', 'LPのワイヤーフレーム', 100),
(1, 1, 1, 2, '画面2のワイヤーフレーム作成', '', 60),
(1, 1, 1, 3, '画面3のワイヤーフレーム作成', '登録画面のワイヤーフレーム', 0),
(1, 2, 2, 4, 'aページからの画面遷移図', 'aページからcページへの遷移図', 100),
(1, 2, 2, 5, 'bページからの画面遷移図', 'bページからdページへの遷移図', 100),
(1, 3, 3, 6, 'エンティティの定義', '', 100),
(1, 3, 3, 7, '正規化', '', 80),
(1, 3, 3, 8, 'ER図', '', 0),
(1, 4, 4, 9, 'タスク出し', '', 100),
(1, 4, 4, 10, '見積もり', '', 100),
(1, 1, 5, 11, 'HTMLで表示する', '', 100),
(1, 1, 5, 12, 'CSSでスタイルを整える', '', 100),
(1, 1, 5, 13, 'JSで動きをつける', '', 100),
(1, 2, 6, 14, 'PHPで...', '', 60),
(1, 2, 6, 15, 'MySQLから...', '', 0),
(1, 3, 7, 16, 'DBに接続する処理', '', 100),
(1, 3, 7, 17, 'エラー時の処理', '', 100),
(1, 4, 8, 18, '登録画面を作成', '', 100),
(1, 4, 8, 19, '通信を暗号化する', '暗号化!!', 80);

-- 初期設定
set @s_project_id = 1;

-- 親タスクを集計してプロジェクト全体の進捗を出す
SELECT  @s_project_progress := (sum(progress) / (count(progress) * 100)) FROM parent_tasks t where project_id = @s_project_id;
UPDATE projects SET progress = @s_project_progress WHERE id = @s_project_id;

INSERT INTO task_status (project_id, user_id, parent_task_id, task_id, status_id) VALUES
(1, 1, 1, 1, 3),
(1, 1, 1, 2, 1),
(1, 1, 1, 3, 1),
(1, 2, 2, 4, 3),
(1, 2, 2, 5, 3),
(1, 3, 3, 6, 3),
(1, 3, 3, 7, 1),
(1, 3, 3, 8, 1),
(1, 4, 4, 9, 3),
(1, 4, 4, 10, 3),
(1, 1, 5, 11, 3),
(1, 1, 5, 12, 3),
(1, 1, 5, 13, 3),
(1, 2, 6, 14, 1),
(1, 2, 6, 15, 1),
(1, 3, 7, 16, 3),
(1, 3, 7, 17, 3),
(1, 4, 8, 18, 3),
(1, 4, 8, 19, 1);

INSERT INTO evaluations (project_id, task_user_id, parent_task_id, task_id, user_id) VALUES
(1, 1, 1, 1, 2),
(1, 1, 1, 1, 3),
(1, 1, 1, 1, 4),
(1, 2, 2, 4, 1),
(1, 2, 2, 4, 3),
(1, 2, 2, 4, 4),
(1, 2, 2, 5, 1),
(1, 2, 2, 5, 3),
(1, 3, 3, 6, 1),
(1, 3, 3, 6, 3),
(1, 4, 4, 9, 2),
(1, 4, 4, 9, 3),
(1, 4, 4, 9, 1),
(1, 4, 4, 10, 1),
(1, 4, 4, 10, 2),
(1, 1, 5, 11, 2),
(1, 1, 5, 11, 3),
(1, 1, 5, 11, 4),
(1, 1, 5, 12, 2),
(1, 1, 5, 12, 3),
(1, 1, 5, 12, 4),
(1, 1, 5, 13, 2),
(1, 1, 5, 13, 3),
(1, 1, 5, 13, 4),
(1, 3, 7, 16, 1),
(1, 3, 7, 16, 2),
(1, 3, 7, 16, 4),
(1, 3, 7, 17, 1),
(1, 3, 7, 17, 4),
(1, 4, 8, 18, 1),
(1, 4, 8, 18, 2),
(1, 4, 8, 18, 3);
