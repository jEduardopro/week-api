<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->cascadeOnDelete();
            $table->foreignId("proyect_id")->nullable()->constrained()->cascadeOnDelete();
            $table->string("name", 255)->index();
            $table->longText("description")->nullable();
            $table->dateTime("due_date")->index();
            $table->foreignId("responsable_id")->nullable()->constrained("users")->cascadeOnDelete();
            $table->tinyInteger("priority")->default(0)->index();
            $table->tinyInteger("status")->default(0)->index();
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
        Schema::dropIfExists('tasks');
    }
}
