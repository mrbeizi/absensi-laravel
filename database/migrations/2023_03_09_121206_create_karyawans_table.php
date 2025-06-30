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
        Schema::create('karyawans', function (Blueprint $table) {
            $table->string('nik',10)->primary();
            $table->string('nama_lengkap',100);
            $table->string('jabatan',20);
            $table->string('no_telp',13);
            $table->string('foto',100)->nullable();
            $table->string('kode_dept',10)->nullable();
            $table->string('kode_cabang',10)->nullable();
            $table->string('status_loc',1)->default(1);
            $table->string('password',255)->nullable();
            $table->string('remember_token',255)->nullable();
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
        Schema::dropIfExists('karyawans');
    }
};
