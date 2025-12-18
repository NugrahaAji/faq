<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateTopicsCollection extends Migration
{
    protected $connection = 'mongodb';

    public function up()
    {
        Schema::connection($this->connection)->table('topics', function ($collection) {
            $collection->index('slug');
            $collection->index('is_active');
        });
    }

    public function down()
    {
        Schema::connection($this->connection)->drop('topics');
    }
}
