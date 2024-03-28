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

INSERT INTO parent_tasks (project_id, user_id, id, title, created_at) VALUES
(1, 1, 1, 'ワイヤーフレームの作成', '2024-03-28 00:00:00'),
(1, 2, 2, '画面遷移図', '2024-03-28 00:00:00'),
(1, 3, 3, 'データベース設計', '2024-03-28 00:00:00'),
(1, 4, 4, 'タスク出し', '2024-03-28 00:00:00'),
(1, 1, 5, 'LPの作成', '2024-03-27 00:00:00'),
(1, 2, 6, 'コア機能実装', '2024-03-27 00:00:00'),
(1, 3, 7, 'データベース周りの実装', '2024-03-27 00:00:00'),
(1, 4, 8, 'ユーザー登録処理の実装', '2024-03-27 00:00:00'),
(1, 1, 9, 'aページの表示処理', '2024-03-26 00:00:00'),
(1, 2, 10, 'bページの表示処理', '2024-03-26 00:00:00'),
(1, 3, 11, 'cページの表示処理', '2024-03-26 00:00:00'),
(1, 4, 12, 'dページの表示処理', '2024-03-26 00:00:00'),
(1, 1, 13, 'aページのスタイルを整える', '2024-03-25 00:00:00'),
(1, 2, 14, 'bページのスタイルを整える', '2024-03-25 00:00:00'),
(1, 3, 15, 'cページのスタイルを整える', '2024-03-25 00:00:00'),
(1, 4, 16, 'dページのスタイルを整える', '2024-03-25 00:00:00'),
(1, 1, 17, 'aページの動的な画面処理', '2024-03-24 00:00:00'),
(1, 2, 18, 'bページの動的な画面処理', '2024-03-24 00:00:00'),
(1, 3, 19, 'cページの動的な画面処理', '2024-03-24 00:00:00'),
(1, 4, 20, 'dページの動的な画面処理', '2024-03-24 00:00:00'),
(1, 1, 21, 'aページのPHP処理', '2024-03-23 00:00:00'),
(1, 2, 22, 'bページのPHP処理', '2024-03-23 00:00:00'),
(1, 3, 23, 'cページのPHP処理', '2024-03-23 00:00:00'),
(1, 4, 24, 'dページのPHP処理', '2024-03-23 00:00:00'),
(1, 1, 25, '1,aページとcページ', '2024-03-22 00:00:00'),
(1, 2, 26, '2,bページとdページ', '2024-03-22 00:00:00'),
(1, 3, 27, '3,aページとcページ', '2024-03-22 00:00:00'),
(1, 4, 28, '4,bページとdページ', '2024-03-22 00:00:00'),
(1, 1, 29, 'ワイヤーフレームの作成', '2024-03-21 00:00:00'),
(1, 2, 30, '画面遷移図', '2024-03-21 00:00:00'),
(1, 3, 31, 'データベース設計', '2024-03-21 00:00:00'),
(1, 4, 32, 'タスク出し', '2024-03-21 00:00:00'),
(1, 1, 33, 'LPの作成', '2024-03-20 00:00:00'),
(1, 2, 34, 'コア機能実装', '2024-03-20 00:00:00'),
(1, 3, 35, 'データベース周りの実装', '2024-03-20 00:00:00'),
(1, 4, 36, 'ユーザー登録処理の実装', '2024-03-20 00:00:00'),
(1, 1, 37, 'aページの表示処理', '2024-03-19 00:00:00'),
(1, 2, 38, 'bページの表示処理', '2024-03-19 00:00:00'),
(1, 3, 39, 'cページの表示処理', '2024-03-19 00:00:00'),
(1, 4, 40, 'dページの表示処理', '2024-03-19 00:00:00'),
(1, 1, 41, 'aページのスタイルを整える', '2024-03-18 00:00:00'),
(1, 2, 42, 'bページのスタイルを整える', '2024-03-18 00:00:00'),
(1, 3, 43, 'cページのスタイルを整える', '2024-03-18 00:00:00'),
(1, 4, 44, 'dページのスタイルを整える', '2024-03-18 00:00:00'),
(1, 1, 45, 'aページの動的な画面処理', '2024-03-17 00:00:00'),
(1, 2, 46, 'bページの動的な画面処理', '2024-03-17 00:00:00'),
(1, 3, 47, 'cページの動的な画面処理', '2024-03-17 00:00:00'),
(1, 4, 48, 'dページの動的な画面処理', '2024-03-17 00:00:00'),
(1, 1, 49, 'aページのPHP処理', '2024-03-16 00:00:00'),
(1, 2, 50, 'bページのPHP処理', '2024-03-16 00:00:00'),
(1, 3, 51, 'cページのPHP処理', '2024-03-16 00:00:00'),
(1, 4, 52, 'dページのPHP処理', '2024-03-16 00:00:00'),
(1, 1, 53, '1,aページとcページ', '2024-03-15 00:00:00'),
(1, 2, 54, '2,bページとdページ', '2024-03-15 00:00:00'),
(1, 3, 55, '3,aページとcページ', '2024-03-15 00:00:00'),
(1, 4, 56, '4,bページとdページ', '2024-03-15 00:00:00'),
(1, 4, 57, '4,React', '2024-03-15 00:00:00');
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
-- ここから
(1, 1, 1, 1, 1),
(1, 1, 1, 1, 2),
(1, 1, 1, 1, 3),
(1, 1, 1, 1, 4),
-- ここまでがひとまとまり
(1, 2, 2, 4, 1),
(1, 2, 2, 4, 2),
(1, 2, 2, 4, 3),
(1, 2, 2, 4, 4),
(1, 2, 2, 5, 1),
(1, 2, 2, 5, 2),
(1, 2, 2, 5, 3),
(1, 2, 2, 5, 4),
(1, 3, 3, 6, 1),
(1, 3, 3, 6, 2),
(1, 3, 3, 6, 3),
(1, 3, 3, 6, 4),
(1, 4, 4, 9, 1),
(1, 4, 4, 9, 2),
(1, 4, 4, 9, 3),
(1, 4, 4, 9, 4),
(1, 4, 4, 10, 1),
(1, 4, 4, 10, 2),
(1, 4, 4, 10, 3),
(1, 4, 4, 10, 4),
(1, 1, 5, 11, 1),
(1, 1, 5, 11, 2),
(1, 1, 5, 11, 3),
(1, 1, 5, 11, 4),
(1, 1, 5, 12, 1),
(1, 1, 5, 12, 2),
(1, 1, 5, 12, 3),
(1, 1, 5, 12, 4),
(1, 1, 5, 13, 1),
(1, 1, 5, 13, 2),
(1, 1, 5, 13, 3),
(1, 1, 5, 13, 4),
(1, 3, 7, 16, 1),
(1, 3, 7, 16, 2),
(1, 3, 7, 16, 3),
(1, 3, 7, 16, 4),
(1, 3, 7, 17, 1),
(1, 3, 7, 17, 2),
(1, 3, 7, 17, 3),
(1, 3, 7, 17, 4),
(1, 4, 8, 18, 1),
(1, 4, 8, 18, 2),
(1, 4, 8, 18, 3),
(1, 4, 8, 18, 4);

INSERT INTO evaluation_tags (project_id, task_user_id, parent_task_id, task_id, user_id, tag_name_id) VALUES
-- １つの子タスクのまとまり
-- task_user_idとuser_idが一致　→　被評価者が評価してほしいtagを3つ(以上)選択
-- このまとまりでは、task_user_id=1,user_id=1
(1, 1, 1, 1, 1, 3),
(1, 1, 1, 1, 1, 4),
(1, 1, 1, 1, 1, 5),
-- task_user_idとuser_idが一致しない　→　評価者が評価したいtagを3つ(以上)選択
-- このまとまりでは、task_user_id=1,user_id=2、user_id=3、user_id=4
(1, 1, 1, 1, 2, 3),
(1, 1, 1, 1, 2, 4),
(1, 1, 1, 1, 2, 5),
(1, 1, 1, 1, 3, 3),
(1, 1, 1, 1, 3, 4),
(1, 1, 1, 1, 3, 5),
(1, 1, 1, 1, 4, 3),
(1, 1, 1, 1, 4, 4),
(1, 1, 1, 1, 4, 5),
-- tagは３つ(以上)選択する必要があるため、一つのまとまりに　4(人)×3(tag) = 12(列)　存在します。
(1, 2, 2, 4, 1, 3),
(1, 2, 2, 4, 1, 4),
(1, 2, 2, 4, 1, 5),
(1, 2, 2, 4, 2, 3),
(1, 2, 2, 4, 2, 4),
(1, 2, 2, 4, 2, 5),
(1, 2, 2, 4, 3, 3),
(1, 2, 2, 4, 3, 4),
(1, 2, 2, 4, 3, 5),
(1, 2, 2, 4, 4, 3),
(1, 2, 2, 4, 4, 4),
(1, 2, 2, 4, 4, 5),
(1, 2, 2, 5, 1, 2),
(1, 2, 2, 5, 1, 3),
(1, 2, 2, 5, 1, 4),
(1, 2, 2, 5, 2, 2),
(1, 2, 2, 5, 2, 3),
(1, 2, 2, 5, 2, 4),
(1, 2, 2, 5, 3, 2),
(1, 2, 2, 5, 3, 3),
(1, 2, 2, 5, 3, 4),
(1, 2, 2, 5, 4, 2),
(1, 2, 2, 5, 4, 3),
(1, 2, 2, 5, 4, 4),
(1, 3, 3, 6, 1, 2),
(1, 3, 3, 6, 1, 4),
(1, 3, 3, 6, 1, 5),
(1, 3, 3, 6, 2, 2),
(1, 3, 3, 6, 2, 4),
(1, 3, 3, 6, 2, 5),
(1, 3, 3, 6, 3, 3),
(1, 3, 3, 6, 3, 4),
(1, 3, 3, 6, 3, 5),
(1, 3, 3, 6, 4, 3),
(1, 3, 3, 6, 4, 4),
(1, 3, 3, 6, 4, 5),
(1, 4, 4, 9, 1, 3),
(1, 4, 4, 9, 1, 4),
(1, 4, 4, 9, 1, 5),
(1, 4, 4, 9, 2, 2),
(1, 4, 4, 9, 2, 3),
(1, 4, 4, 9, 2, 5),
(1, 4, 4, 9, 3, 3),
(1, 4, 4, 9, 3, 4),
(1, 4, 4, 9, 3, 5),
(1, 4, 4, 9, 4, 3),
(1, 4, 4, 9, 4, 4),
(1, 4, 4, 9, 4, 5),
(1, 4, 4, 10, 1, 2),
(1, 4, 4, 10, 1, 3),
(1, 4, 4, 10, 1, 4),
(1, 4, 4, 10, 2, 2),
(1, 4, 4, 10, 2, 3),
(1, 4, 4, 10, 2, 4),
(1, 4, 4, 10, 3, 3),
(1, 4, 4, 10, 3, 4),
(1, 4, 4, 10, 3, 5),
(1, 4, 4, 10, 4, 2),
(1, 4, 4, 10, 4, 3),
(1, 4, 4, 10, 4, 4),
(1, 1, 5, 11, 1, 1),
(1, 1, 5, 11, 1, 3),
(1, 1, 5, 11, 1, 5),
(1, 1, 5, 11, 2, 1),
(1, 1, 5, 11, 2, 3),
(1, 1, 5, 11, 2, 5),
(1, 1, 5, 11, 3, 1),
(1, 1, 5, 11, 3, 3),
(1, 1, 5, 11, 3, 5),
(1, 1, 5, 11, 4, 1),
(1, 1, 5, 11, 4, 2),
(1, 1, 5, 11, 4, 3),
(1, 1, 5, 12, 1, 1),
(1, 1, 5, 12, 1, 3),
(1, 1, 5, 12, 1, 5),
(1, 1, 5, 12, 2, 1),
(1, 1, 5, 12, 2, 3),
(1, 1, 5, 12, 2, 5),
(1, 1, 5, 12, 3, 1),
(1, 1, 5, 12, 3, 4),
(1, 1, 5, 12, 3, 5),
(1, 1, 5, 12, 4, 1),
(1, 1, 5, 12, 4, 2),
(1, 1, 5, 12, 4, 4),
(1, 1, 5, 13, 1, 1),
(1, 1, 5, 13, 1, 2),
(1, 1, 5, 13, 1, 3),
(1, 1, 5, 13, 2, 1),
(1, 1, 5, 13, 2, 2),
(1, 1, 5, 13, 2, 3),
(1, 1, 5, 13, 3, 1),
(1, 1, 5, 13, 3, 3),
(1, 1, 5, 13, 3, 5),
(1, 1, 5, 13, 4, 1),
(1, 1, 5, 13, 4, 3),
(1, 1, 5, 13, 4, 5),
(1, 3, 7, 16, 1, 2),
(1, 3, 7, 16, 1, 3),
(1, 3, 7, 16, 1, 5),
(1, 3, 7, 16, 2, 2),
(1, 3, 7, 16, 2, 3),
(1, 3, 7, 16, 2, 4),
(1, 3, 7, 16, 3, 2),
(1, 3, 7, 16, 3, 3),
(1, 3, 7, 16, 3, 5),
(1, 3, 7, 16, 4, 1),
(1, 3, 7, 16, 4, 3),
(1, 3, 7, 16, 4, 4),
(1, 3, 7, 17, 1, 2),
(1, 3, 7, 17, 1, 4),
(1, 3, 7, 17, 1, 5),
(1, 3, 7, 17, 2, 1),
(1, 3, 7, 17, 2, 2),
(1, 3, 7, 17, 2, 3),
(1, 3, 7, 17, 3, 1),
(1, 3, 7, 17, 3, 3),
(1, 3, 7, 17, 3, 5),
(1, 3, 7, 17, 4, 1),
(1, 3, 7, 17, 4, 3),
(1, 3, 7, 17, 4, 5),
(1, 4, 8, 18, 1, 1),
(1, 4, 8, 18, 1, 3),
(1, 4, 8, 18, 1, 5),
(1, 4, 8, 18, 2, 1),
(1, 4, 8, 18, 2, 4),
(1, 4, 8, 18, 2, 5),
(1, 4, 8, 18, 3, 1),
(1, 4, 8, 18, 3, 3),
(1, 4, 8, 18, 3, 5),
(1, 4, 8, 18, 4, 1),
(1, 4, 8, 18, 4, 3),
(1, 4, 8, 18, 4, 5);
