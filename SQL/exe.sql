DROP DATABASE IF EXISTS team_weekly_report;

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
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE users (
    id INT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    avatar_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
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
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT,
    user_id INT,
    title VARCHAR(128) NOT NULL,
    progress FLOAT DEFAULT 0 NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (project_id) REFERENCES projects (id)
);

/*
contentにtaskの詳細を記入
 */
CREATE TABLE child_tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    parent_task_id INT,
    title VARCHAR(128) NOT NULL,
    content TEXT,
    progress FLOAT DEFAULT 0 NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_task_id) REFERENCES parent_tasks (id)
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
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE task_status (
    child_task_id INT,
    status_id INT,
    isStatus BOOLEAN DEFAULT FALSE,
    primary key (child_task_id, status_id),
    FOREIGN KEY (child_task_id) REFERENCES child_tasks (id),
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
    id INT AUTO_INCREMENT PRIMARY KEY,
    child_task_id INT,
    user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (child_task_id) REFERENCES child_tasks (id),
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
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

/*
evaluation_tagsテーブルを使って、評価して欲しいタスクを設定する
 */
CREATE TABLE evaluation_tags(
    evaluation_id INT,
    tag_name_id INT,
    isEvaluated BOOLEAN DEFAULT FALSE,
    comment VARCHAR(255),
    PRIMARY KEY (evaluation_id, tag_name_id),
    FOREIGN KEY (evaluation_id) REFERENCES evaluations (id),
    FOREIGN KEY (tag_name_id) REFERENCES tags(id)
);

/*
advanced 子タスクへのコメント
 */

CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    child_task_id INT,
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (child_task_id) REFERENCES child_tasks (id)
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
    comment_id INT,
    commented_user_id INT,
    isRead BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (comment_id, commented_user_id),
    FOREIGN KEY (comment_id) REFERENCES comments (id),
    FOREIGN KEY (commented_user_id) REFERENCES users (id)
);

INSERT INTO users (id, name, email, password, avatar_url) VALUES
(1, '柳瀬', 'ynstakeru@gmail.com', 'password', 'https://drive.google.com/file/d/1FXvhb0P416fJKwo-3_y8J3SmxDq65_kR/view?usp=sharing'),
(2, '尾崎', 'gintoki@gmail.com', 'password', ''),
(3, '松岡', 'ryuumasann@gmail.com', 'password', ''),
(4, '松浦', 'ryuunosukematsuoka@gmail.com', 'password', '');

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

-- (project_id, user_id, title, progress, created_at)
INSERT INTO parent_tasks (project_id, user_id, title, progress, created_at) VALUES
(1, 1,'ワイヤーフレームの作成', 30, '2024-03-28 00:00:00'),
(1, 2,'画面遷移図', 60,'2024-03-28 00:00:00'),
(1, 3,'データベース設計', 80, '2024-03-28 00:00:00'),
(1, 4,'タスク出し', 100, '2024-03-28 00:00:00'),
(1, 1,'LPの作成', 0, '2024-03-27 00:00:00'),
(1, 2,'コア機能実装', 80, '2024-03-27 00:00:00'),
(1, 3,'データベース周りの実装', 80, '2024-03-27 00:00:00'),
(1, 4,'ユーザー登録処理の実装', 80, '2024-03-27 00:00:00'),
(1, 1,'aページの表示処理', 80, '2024-03-26 00:00:00'),
(1, 2, 'bページの表示処理', 80, '2024-03-26 00:00:00'),
(1, 3, 'cページの表示処理', 80, '2024-03-26 00:00:00'),
(1, 4, 'dページの表示処理', 80, '2024-03-26 00:00:00'),
(1, 1, 'aページのスタイルを整える', 80, '2024-03-25 00:00:00'),
(1, 2, 'bページのスタイルを整える', 80, '2024-03-25 00:00:00'),
(1, 3, 'cページのスタイルを整える', 80, '2024-03-25 00:00:00'),
(1, 4, 'dページのスタイルを整える', 80, '2024-03-25 00:00:00'),
(1, 1, 'aページの動的な画面処理', 80, '2024-03-24 00:00:00'),
(1, 2, 'bページの動的な画面処理', 80, '2024-03-24 00:00:00'),
(1, 3, 'cページの動的な画面処理', 80, '2024-03-24 00:00:00'),
(1, 4, 'dページの動的な画面処理', 80, '2024-03-24 00:00:00'),
(1, 1, 'aページのPHP処理', 80, '2024-03-23 00:00:00'),
(1, 2, 'bページのPHP処理', 80, '2024-03-23 00:00:00'),
(1, 3, 'cページのPHP処理', 80, '2024-03-23 00:00:00'),
(1, 4, 'dページのPHP処理', 80, '2024-03-23 00:00:00'),
(1, 1, '1,aページとcページ', 80, '2024-03-22 00:00:00'),
(1, 2, '2,bページとdページ', 80, '2024-03-22 00:00:00'),
(1, 3, '3,aページとcページ', 80, '2024-03-22 00:00:00'),
(1, 4, '4,bページとdページ', 80, '2024-03-22 00:00:00'),
(1, 1, 'ワイヤーフレームの作成', 80, '2024-03-21 00:00:00'),
(1, 2, '画面遷移図', 80, '2024-03-21 00:00:00'),
(1, 3, 'データベース設計', 80, '2024-03-21 00:00:00'),
(1, 4, 'タスク出し', 80, '2024-03-21 00:00:00'),
(1, 1, 'LPの作成', 80, '2024-03-20 00:00:00'),
(1, 2, 'コア機能実装', 80, '2024-03-20 00:00:00'),
(1, 3, 'データベース周りの実装', 80, '2024-03-20 00:00:00'),
(1, 4, 'ユーザー登録処理の実装', 80, '2024-03-20 00:00:00'),
(1, 1, 'aページの表示処理', 80, '2024-03-19 00:00:00'),
(1, 2, 'bページの表示処理', 80, '2024-03-19 00:00:00'),
(1, 3, 'cページの表示処理', 80, '2024-03-19 00:00:00'),
(1, 4, 'dページの表示処理', 80, '2024-03-19 00:00:00'),
(1, 1, 'aページのスタイルを整える', 80, '2024-03-18 00:00:00'),
(1, 2, 'bページのスタイルを整える', 80, '2024-03-18 00:00:00'),
(1, 3, 'cページのスタイルを整える', 80, '2024-03-18 00:00:00'),
(1, 4, 'dページのスタイルを整える', 80, '2024-03-18 00:00:00'),
(1, 1, 'aページの動的な画面処理', 80, '2024-03-17 00:00:00'),
(1, 2, 'bページの動的な画面処理', 80, '2024-03-17 00:00:00'),
(1, 3, 'cページの動的な画面処理', 80, '2024-03-17 00:00:00'),
(1, 4, 'dページの動的な画面処理', 80, '2024-03-17 00:00:00'),
(1, 1, 'aページのPHP処理', 80, '2024-03-16 00:00:00'),
(1, 2, 'bページのPHP処理', 80, '2024-03-16 00:00:00'),
(1, 3, 'cページのPHP処理', 80, '2024-03-16 00:00:00'),
(1, 4, 'dページのPHP処理', 80, '2024-03-16 00:00:00'),
(1, 1, '1,aページとcページ', 80, '2024-03-15 00:00:00'),
(1, 2, '2,bページとdページ', 80, '2024-03-15 00:00:00'),
(1, 3, '3,aページとcページ', 80, '2024-03-15 00:00:00'),
(1, 4, '4,bページとdページ', 80, '2024-03-15 00:00:00'),
(1, 4, '4,React', 80, '2024-03-15 00:00:00');

INSERT INTO child_tasks (parent_task_id, title, content, progress) VALUES
(1, '画面1のワイヤーフレーム作成', 'LPのワイヤーフレーム', 100),
(1, '画面2のワイヤーフレーム作成', '', 60),
(1, '画面3のワイヤーフレーム作成', '登録画面のワイヤーフレーム', 0),
(2, 'aページからの画面遷移図', 'aページからcページへの遷移図', 100),
(2, 'bページからの画面遷移図', 'bページからdページへの遷移図', 100),
(3, 'エンティティの定義', '', 100),
(3, '正規化', '', 80),
(3, 'ER図', '', 0),
(4, 'タスク出し', '', 100),
(4,  '見積もり', '', 100),
(5,  'HTMLで表示する', '', 100),
(5,  'CSSでスタイルを整える', '', 100),
(5,  'JSで動きをつける', '', 100),
(6,  'PHPで...', '', 60),
(6,  'MySQLから...', '', 0),
(7,  'DBに接続する処理', '', 100),
(7,  'エラー時の処理', '', 100),
(8,  '登録画面を作成', '', 100),
(8,  '通信を暗号化する', '暗号化!!', 80),
(9, "mainタグのHTML構造を実装", 'contianerクラスを使ってみました', 100),
(9, "CSSの適用", '', 80),
(9, "ホバーなどのアニメーションの付与", '', 60),
(9, "サーバーにデータを送信する", '', 30),
(9, "サーバーからデータをとってくる", '', 0);



-- 初期設定
set @s_project_id = 1;

-- 親タスクを集計してプロジェクト全体の進捗を出す
SELECT  @s_project_progress := (sum(progress) / (count(progress))) FROM parent_tasks t where project_id = @s_project_id;
UPDATE projects SET progress = @s_project_progress WHERE id = @s_project_id;

INSERT INTO task_status (child_task_id, status_id) VALUES
(1, 3),
(2, 1),
(3, 1),
(4, 3),
(5, 3),
(6, 3),
(7, 1),
(8, 1),
(9, 3),
(10, 3),
(11, 3),
(12, 3),
(13, 3),
(14, 1),
(15, 1),
(16, 3),
(17, 3),
(18, 3),
(19, 1);
