<?php

namespace model;

class ParentTask
{
    public int $project_id;
    public int $user_id;
    public int $id;
    public string $title;
    public float $progress;
    public string $created_at;



    public function getDate(): string
    {
        $date = new \DateTime($this->created_at);
        $week = ['日', '月', '火', '水', '木', '金', '土'];
        $w = (int)$date->format('w');
        return $date->format('m月d日'). ' ' . $week[$w] . "曜日";
    }
}
