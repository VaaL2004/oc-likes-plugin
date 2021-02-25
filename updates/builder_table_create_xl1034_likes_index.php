<?php namespace Xl1034\Likes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateXl1034LikesIndex extends Migration
{
    public function up()
    {
        Schema::create('xl1034_likes_index', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->boolean('is_dislike')->default(0);
            $table->integer('likeable_id');
            $table->string('likeable_type');
            $table->integer('user_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('xl1034_likes_index');
    }
}