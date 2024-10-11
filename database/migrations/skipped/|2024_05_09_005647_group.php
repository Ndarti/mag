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
        Schema::create('_Group', function (Blueprint $table) {
            $table->id();
            $table->string('group_name');
            $table->string('course');
            $table->string('manager_id');
            $table->text('teacher_id');
            $table->string('speciality');

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
