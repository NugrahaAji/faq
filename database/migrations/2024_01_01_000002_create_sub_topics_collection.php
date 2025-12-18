<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateSubTopicsCollection extends Migration
{
    protected $connection = 'mongodb';

    public function up()
    {
        Schema::connection($this->connection)->table('sub_topics', function ($collection) {
            $collection->index('topic_id');
            $collection->index('slug');
            $collection->index('is_active');
        });
    }

    public function down()
    {
        Schema::connection($this->connection)->drop('sub_topics');
    }
}
