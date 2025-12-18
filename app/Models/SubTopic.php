<?php

namespace App\Models;
use Jenssegers\Mongodb\Eloquent\Model;

class SubTopic extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'sub_topics';

    protected $fillable = [
        'topic_id',
        'name',
        'slug',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi ke Topic
    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id');
    }

    // Relasi ke FAQ
    public function faqs()
    {
        return $this->hasMany(Faq::class, 'sub_topic_id');
    }
}
