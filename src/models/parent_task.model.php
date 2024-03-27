<?php

namespace model;

class ParentTask
{
    public int $project_id;
    public int $user_id;
    public int $id;
    public float $progress;
    public string $title;
    public string $created_at;

    public function getDate() : string
    {
        $date = new \DateTime($this->created_at);
        // 曜日を取得
        $week = ['日', '月', '火', '水', '木', '金', '土'];
        $w = (int)$date->format('w');
        return $date->format('m月d日'). ' ' . $week[$w] . '曜日';
    }
}
