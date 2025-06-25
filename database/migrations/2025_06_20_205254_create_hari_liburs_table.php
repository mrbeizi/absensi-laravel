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
        Schema::create('hari_liburs', function (Blueprint $table) {
            $table->string('kode_libur')->primary();
            $table->date('tgl_libur');
            $table->string('kode_cabang',10)->nullable();
            $table->string('keterangan',255)->nullable();
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
        Schema::dropIfExists('hari_liburs');
    }
};
