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



CREATE TABLE tasks (
    project_id INT,
    user_id INT,
    id INT,
    date DATE NOT NULL,
    learning_time INT NOT NULL,
    title VARCHAR(128) NOT NULL,
    content TEXT,
    progress INT DEFAULT 0 NOT NULL,
    created_at TIMESTAMP,
    PRIMARY KEY (project_id, user_id, id),
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (project_id) REFERENCES projects (id)
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
    FOREIGN KEY (project_id, user_id, task_id) REFERENCES tasks (project_id, user_id, id),
    FOREIGN KEY (status_id) REFERENCES status (id)
);

/*
メンバーのタスク評価項目を全て完了するとevaluationsテーブルに1行追加する
ユーザーの総数を取得し
evaluationsテーブルを使って、タスクの評価が完了したユーザーの総数を取得する
evaluations評価が完了すると、isEvaluationをTRUEにする
 */

CREATE TABLE evaluations(
    project_id INT,
    task_user_id INT,
    task_id INT,
    user_id INT,
    isEvaluated BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP,
    PRIMARY KEY (project_id, task_user_id, task_id, user_id),
    FOREIGN KEY (project_id, task_user_id, task_id) REFERENCES tasks (project_id, user_id, id),
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
    FOREIGN KEY (project_id, task_user_id, task_id) REFERENCES tasks (project_id, user_id, id),
    FOREIGN KEY (tag_name_id) REFERENCES tags(id)
);

-- scoreは各人で初期値に+1ポイント持っておくようにする

/*
evaluationsテーブルのisEvaluationがTRUEにする条件
メンバー全員が評価を完了した場合
レコード数がプロジェクトメンバーの数 * 3以上になっている
 */

CREATE TABLE scores (
    project_id INT,
    task_id INT,
    task_user_id INT,
    user_id INT,
    tag_name_id INT,
    PRIMARY KEY (project_id, task_user_id, task_id, user_id, tag_name_id),
    score INT DEFAULT 1 NOT NULL,
    created_at TIMESTAMP,
    Foreign Key (project_id, task_user_id, task_id) REFERENCES tasks (project_id, user_id, id),
    Foreign Key (user_id) REFERENCES users (id),
    Foreign Key (tag_name_id) REFERENCES tags(id)
);


/*
以降はadvanced
 */

CREATE TABLE comments (
    project_id INT,
    task_user_id INT,
    task_id INT,
    user_id INT,
    comment TEXT NOT NULL,
    created_at TIMESTAMP,
    PRIMARY KEY (project_id, task_user_id, task_id, user_id),
    FOREIGN KEY (project_id, task_user_id, task_id) REFERENCES tasks (project_id, user_id, id),
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

INSERT INTO projects (id, title, content, created_at) VALUES
(1, 'TEAM WEEKLY REPORT', 'TEAM WEEKLY REPORTの内容', concat( date_sub(current_date(), interval 120 day))),
(2, 'プロジェクト2', 'プロジェクト2の内容', concat( date_sub(current_date(), interval 120 day))),
(3, 'プロジェクト3', 'プロジェクト3の内容', concat( date_sub(current_date(), interval 120 day))),
(4, 'プロジェクト4', 'プロジェクト4の内容', concat( date_sub(current_date(), interval 120 day)));
