-- 初期設定
set @s_project_id = 1;

-- デモで扱う分には固定のIDでもいいかも？
SELECT title FROM projects p  where id = @s_project_id;

-- 親タスクを集計してプロジェクト全体の進捗を出す
SELECT  @s_project_progress := (sum(progress) / (count(progress) * 100)) FROM parent_tasks t where project_id = @s_project_id;

UPDATE projects SET progress = @s_project_progress WHERE id = @s_project_id;
