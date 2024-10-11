<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('_Mag', function (Blueprint $table) {
            $table->id();
            $table->string('id_students');
            $table->string('id_group');
            $table->string('id_subj');
            $table->string('id_teacher')->nullable();
            $table->string('tip_mark')->nullable();
            $table->string('mark')->nullable();
            $table->string('propysk')->nullable();
            $table->timestamp('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
