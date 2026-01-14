<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForumTopicRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_topic_replies', function (Blueprint $table) {
            $table->id();  
            $table->foreignId('auth_id')->constrained('users')->onDelete('cascade');  
            $table->foreignId('forum_post_id')->constrained('forum_posts')->onDelete('cascade');  
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');  
            $table->text('content');  
            $table->timestamps();  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forum_topic_replies');
    }
}
