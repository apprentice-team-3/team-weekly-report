-- DROP DATABASE IF EXISTS team_weekly_report;

create database team_weekly_report character set 'utf8mb4';
use team_weekly_report;

/*
progressは1~5で、5になったら完了とする
 */

CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(128) NOT NULL,
    content TEXT NOT NULL,
    progress FLOAT DEFAULT 0 NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
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
	id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    project_id INT,
    /* PRIMARY KEY (user_id, project_id), */
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
  id INT AUTO_INCREMENT PRIMARY KEY,
  child_task_id INT,
  status_id INT,
  isStatus BOOLEAN DEFAULT FALSE,
  FOREIGN KEY (child_task_id) REFERENCES child_tasks (id),
  FOREIGN KEY (status_id) REFERENCES status (id)
);

CREATE TABLE evaluations(
  id INT AUTO_INCREMENT PRIMARY KEY,
  child_task_id INT,
  user_id INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (child_task_id) REFERENCES child_tasks (id),
  FOREIGN KEY (user_id) REFERENCES users (id)
);

CREATE TABLE tags (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(128) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE evaluation_tags(
  id INT AUTO_INCREMENT PRIMARY KEY,
  evaluation_id INT,
  tag_id INT,
  isEvaluated BOOLEAN DEFAULT FALSE,
  comment VARCHAR(255),
  FOREIGN KEY (evaluation_id) REFERENCES evaluations (id),
  FOREIGN KEY (tag_id) REFERENCES tags(id)
);

CREATE TABLE comments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  parent_task_id INT,
  user_id INT,
  comment TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (parent_task_id) REFERENCES parent_tasks (id),
  FOREIGN KEY (user_id) REFERENCES users (id)
);

CREATE TABLE is_read_comment(
  id INT AUTO_INCREMENT PRIMARY KEY,
  comment_id INT,
  user_id INT,
  isRead BOOLEAN DEFAULT FALSE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (comment_id) REFERENCES comments (id),
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
(4, '見積もり', '', 100),
(5, 'HTMLで表示する', '', 100),
(5, 'CSSでスタイルを整える', '', 100),
(5, 'JSで動きをつける', '', 100),
(6, 'PHPで...', '', 60),
(6, 'MySQLから...', '', 0),
(7, 'DBに接続する処理', '', 100),
(7, 'エラー時の処理', '', 100),
(8, '登録画面を作成', '', 100),
(8, '通信を暗号化する', '暗号化!!', 80);

-- 初期設定
set @s_project_id = 1;

-- 子タスクを集計して親タスクの進捗を出す
SELECT @s_parent_progress := (sum(progress) / (count(progress) * 100))
FROM child_tasks t
INNER JOIN parent_tasks pt ON t.parent_task_id = pt.id
WHERE pt.id = @s_project_id;

-- 親タスクの進捗を更新
UPDATE parent_tasks SET progress = @s_parent_progress WHERE id = @s_project_id;

-- 親タスクを集計してプロジェクト全体の進捗を出す
SELECT @s_project_progress := (sum(progress) / (count(progress) * 100))
FROM parent_tasks t
WHERE id = @s_project_id;

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