<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('poster');
            $table->enum('type', ['image', 'video']);
            $table->string('url');
            $table->string('description',1000);
            $table->boolean('is_trashed')->default(0);
            $table->boolean('is_archived')->default(0);
            $table->boolean('is_public')->default(0);
            $table->boolean('is_friends')->default(0);
            $table->boolean('is_family')->default(0);
            $table->boolean('is_friends_family')->default(0);
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
        Schema::dropIfExists('medias');
    }
}
