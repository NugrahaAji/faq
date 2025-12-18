<?php

namespace App\Models;
use Jenssegers\Mongodb\Eloquent\Model;

class Faq extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'faqs';

    protected $fillable = [
        'topic_id',
        'sub_topic_id',
        'question',
        'answer',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi ke Topic
    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id');
    }

    // Relasi ke SubTopic
    public function subTopic()
    {
        return $this->belongsTo(SubTopic::class, 'sub_topic_id');
    }
}
