<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('channel_id')->comment('チャンネルID');
            $table->unsignedBigInteger('user_id')->comment('利用者ID');
            $table->unsignedBigInteger('reply_id')->comment('返信先ID');
            $table->string('message', 100)->comment('メッセージ内容');
            $table->softDeletes();
            $table->timestamps();

            $table->index('id');
            $table->index('channel_id');
            $table->index('user_id');
            $table->index('reply_id');
            $table->index('message');

            $table->foreign('channel_id')
                ->references('id')
                ->on('channels')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
