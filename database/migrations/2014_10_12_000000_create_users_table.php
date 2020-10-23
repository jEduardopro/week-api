<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("departments", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("slug");
            $table->longText("about")->nullable();
            $table->timestamps();
        });

        Schema::create("users", function (Blueprint $table) {
            $table->id();
            $table->foreignId("department_id")->constrained()->cascadeOnDelete();
            $table->string("name")->index();
            $table->string("email")->unique()->index();
            $table->timestamp("email_verified_at")->nullable();
            $table->string("password");
            $table->string("slug", 255)->nullable();
            $table->string("image")->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists("departments");
        Schema::dropIfExists("users");
    }
}
