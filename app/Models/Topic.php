<?php

namespace App\Models;
use Jenssegers\Mongodb\Eloquent\Model;

class Topic extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'topics';

    protected $fillable = [
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

    // Relasi ke SubTopic
    public function subTopics()
    {
        return $this->hasMany(SubTopic::class, 'topic_id');
    }

    // Relasi ke FAQ
    public function faqs()
    {
        return $this->hasMany(Faq::class, 'topic_id');
    }
}
