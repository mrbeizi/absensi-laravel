<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan_izins', function (Blueprint $table) {
            $table->string('kode_izin',10);
            $table->string('nik',6);
            $table->date('tgl_izin_dari');
            $table->date('tgl_izin_sampai');
            $table->string('status',1);
            $table->string('keterangan',100);
            $table->string('docs_sid',15)->nullable();
            $table->string('status_approved',1);
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
        Schema::dropIfExists('pengajuan_izins');
    }
};
