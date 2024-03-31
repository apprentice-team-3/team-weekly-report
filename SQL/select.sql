-- 初期設定
set @s_project_id = 1;

-- デモで扱う分には固定のIDでもいいかも？
SELECT title FROM projects p  where id = @s_project_id;

-- 親タスクを集計してプロジェクト全体の進捗を出す
SELECT  @s_project_progress := (sum(progress) / (count(progress))) FROM parent_tasks t where project_id = @s_project_id;
UPDATE projects SET progress = @s_project_progress WHERE id = @s_project_id;

-- 子タスクを集計して親タスクの進捗を出す
SELECT  @s_parent_progress := (sum(progress) / (count(progress))) FROM child_tasks t where project_id = @s_project_id;

select * from parent_task;

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




select parent_task_id , sum( progress ) / count(progress) from child_tasks c group by c.parent_task_id where parent_task_id = 1 ;

select parent_task_id , sum( progress ) / count(progress) from child_tasks c where parent_task_id = 1 group by c.parent_task_id;

-- 上記SQLを使ってparent_task_idのprogressを更新する
UPDATE parent_tasks p
SET progress = (select parent_task_id , sum( progress ) / count(progress) from child_tasks c where parent_task_id = 1 group by c.parent_task_id)
WHERE project_id = @s_project_id and WHERE id = 1;

update parent_tasks p
set progress = 0
where project_id = 1 and id = 1;
