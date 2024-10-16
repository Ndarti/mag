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
    {  {
        Schema::create('__teacher_subject', function (Blueprint $table) {
            $table->id();
            $table->text('teacher_id');
            $table->text('subject_id');
            $table->timestamps();
        });}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
