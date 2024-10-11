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
        Schema::create('_gr_sub', function (Blueprint $table) {
            $table->id();
            $table->string('id_group');
            $table->string('id_subj');});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
