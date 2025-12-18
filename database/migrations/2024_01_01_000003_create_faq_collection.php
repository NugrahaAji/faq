<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateFaqCollection extends Migration
{
    protected $connection = 'mongodb';

    public function up()
    {
        Schema::connection($this->connection)->table('faqs', function ($collection) {
            $collection->index('topic_id');
            $collection->index('sub_topic_id');
            $collection->index('is_active');
            $collection->index('order');
        });
    }

    public function down()
    {
        Schema::connection($this->connection)->drop('faqs');
    }
}
