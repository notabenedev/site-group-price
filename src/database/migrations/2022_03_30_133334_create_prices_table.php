<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {

            $table->increments('id');

            $table->string('title');

            $table->string('slug')
                ->unique();

            $table->string('price');

            $table->string('description')
                ->nullable();

            $table->string('priority')
                ->default(1)
                ->comment("Приоритет");

            $table->unsignedBigInteger("group_id")
                ->comment("Группа");

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
        Schema::dropIfExists('prices');
    }
}
