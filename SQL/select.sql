-- 初期設定
set @s_project_id = 1;

-- デモで扱う分には固定のIDでもいいかも？
SELECT title FROM projects p  where id = @s_project_id;

-- 親タスクを集計してプロジェクト全体の進捗を出す
SELECT  @s_project_progress := (sum(progress) / (count(progress) * 100)) FROM parent_tasks t where project_id = @s_project_id;
UPDATE projects SET progress = @s_project_progress WHERE id = @s_project_id;

-- 子タスクを集計して親タスクの進捗を出す
SELECT  @s_parent_progress := (sum(progress) / (count(progress) * 100)) FROM child_tasks t where project_id = @s_project_id;

-- 親タスクの進捗を更新
UPDATE parent_tasks SET progress = @s_parent_progress WHERE project_id = @s_project_id;

-- 被評価者が指定したtagを取得する
SELECT t.task_id, tg.name
FROM evaluation_tags t
INNER JOIN tags tg ON t.tag_name_id = tg.id
WHERE t.task_user_id = t.user_id
GROUP BY t.task_id, tg.name;

-- 評価者が指定したtagを取得する
SELECT t.task_id, t.user_id ,tg.name
FROM evaluation_tags t
INNER JOIN tags tg ON t.tag_name_id = tg.id
WHERE t.task_user_id <> t.user_id
GROUP BY t.task_id, t.user_id ,tg.name;

--  親タスクを日付ごとに新しい順で7件取得する

SELECT count(id),@s_created_at := created_at FROM parent_tasks WHERE project_id = @s_project_id GROUP BY created_at ORDER BY created_at DESC LIMIT 7;
SELECT @s_created_at;

