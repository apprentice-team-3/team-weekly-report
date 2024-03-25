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
(1, 1, 'ワイヤーフレームの作成', 0),
(1, 2, '画面遷移図', 0),
(1, 3, 'データベース設計', 0),
(1, 4, 'タスク出し', 0),
(1, 1, 'LPの作成', 0),
(1, 2, 'コア機能実装', 0),
(1, 3, 'データベース周りの実装', 0),
(1, 4, 'ユーザー登録処理の実装', 0),
(1, 1, 'aページの表示処理', 0),
(1, 2, 'bページの表示処理', 0),
(1, 3, 'cページの表示処理', 0),
(1, 4, 'dページの表示処理', 0),
(1, 1, 'aページのスタイルを整える', 0),
(1, 2, 'bページのスタイルを整える', 0),
(1, 3, 'cページのスタイルを整える', 0),
(1, 4, 'dページのスタイルを整える', 0),
(1, 1, 'aページの動的な画面処理', 0),
(1, 2, 'bページの動的な画面処理', 0),
(1, 3, 'cページの動的な画面処理', 0),
(1, 4, 'dページの動的な画面処理', 0);
