<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHoaDonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hoa_dons', function (Blueprint $table) {
            $table->id();
            $table->string('ma_hoa_don');
            $table->double('tong_tien', 18, 0);
            $table->double('tien_giam_gia', 18, 0);
            $table->double('thuc_tra', 18, 0);
            $table->integer('agent_id');
            $table->integer('id_ban');
            $table->integer('loai_thanh_toan');
            $table->integer('xuat_hoa_don')->default(1);
            $table->date('ngay_hoa_don');
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
        Schema::dropIfExists('hoa_dons');
    }
}
