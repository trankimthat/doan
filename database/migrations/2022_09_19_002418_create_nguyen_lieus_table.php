<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNguyenLieusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nguyen_lieus', function (Blueprint $table) {
            $table->id();
            $table->string('ten_nguyen_lieu');
            $table->string('slug_nguyen_lieu');
            $table->integer('so_luong')->default(0);
            $table->string('don_vi');
            $table->integer('is_open')->default(1);
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
        Schema::dropIfExists('nguyen_lieus');
    }
}
