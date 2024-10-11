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
        Schema::create('_EntranceModels', function (Blueprint $table) {
            $table->id();
            $table->string('fio');
            $table->string('email');
            $table->string('password');
            $table->text('statys');
            $table->string('created_at');
            $table->string('updated_at');

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
