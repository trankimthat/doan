<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXuatKhosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xuat_khos', function (Blueprint $table) {
            $table->id();
            $table->string('id_nguyen_lieu');
            $table->string('ten_nguyen_lieu');
            $table->integer('so_luong')->default(0);
            // $table->string('don_vi');
            $table->integer('type')->default(0);
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
        Schema::dropIfExists('xuat_khos');
    }
}
