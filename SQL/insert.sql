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

