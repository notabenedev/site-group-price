<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {

            $table->increments('id');

            $table->string('title');

            $table->string('slug')
                ->unique();

            $table->tinyText('short')
                ->nullable()
                ->comment("Краткое описание");

            $table->text("description")
                ->nullable()
                ->comment("Описание");

            $table->tinyText("accent")
                ->nullable()
                ->comment("Акцент");

            $table->text("info")
                ->nullable()
                ->comment('Дополнительная информация');

            $table->dateTime("published_at")
                ->nullable()
                ->comment('Дата публикации');

            $table->unsignedBigInteger("parent_id")
                ->nullable()
                ->comment("Родительская группа");

            $table->unsignedBigInteger("priority")
                ->default(0)
                ->comment("Приоритет");

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
        Schema::dropIfExists('groups');
    }
}
