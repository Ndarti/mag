<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('group__teachers', function (Blueprint $table) {
            $table->id();
            $table->text('group_id'); // Assuming 'group_id' is the foreign key
            $table->text('teacher_id'); // Assuming 'teacher_id' is the foreign key
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->text('is_primary') ;
            $table->text('role')->nullable();
            $table->text('comments')->nullable();
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
