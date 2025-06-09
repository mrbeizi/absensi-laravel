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
        Schema::create('konfigurasi_jam_kerja_department_details', function (Blueprint $table) {
            $table->string('kode_jam_kerja_dept',7);
            $table->string('hari',10);
            $table->string('kode_jam_kerja',255);
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
        Schema::dropIfExists('konfigurasi_jam_kerja_department_details');
    }
};
