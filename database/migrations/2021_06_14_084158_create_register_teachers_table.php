<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegisterTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string("mapel");
            $table->string("slug");
            $table->dateTimeTz("dimulai");
            $table->dateTimeTz("berakhir");
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
        Schema::dropIfExists('register_teachers');
    }
}
