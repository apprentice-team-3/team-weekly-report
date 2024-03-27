<?php

namespace model;
class WeeklyTask{
    public array $parent_tasks;
    public string $date;

    public function __construct(){
        $this->parent_tasks = [];
    }

    public function addParentTask(ParentTask $parent_task){
        if(!$this->parent_tasks){
            $this->date = (new \DateTime($parent_task->created_at))->format('Y-m-d');

            $this->parent_tasks[] = $parent_task;
            return;
        }
        if ($this->date === $parent_task->created_at) {
            $this->parent_tasks[] = $parent_task;
        }

    }

    public function getDate(){
        if($this->parent_tasks){
            return $this->parent_tasks[0]->getDate();
        }
    }
}
