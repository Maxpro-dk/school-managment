<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->date('birth_date');
            $table->enum('gender', ['M', 'F']);
            $table->string('registration_number', 50)->unique();
            $table->foreignId('school_class_id')->constrained('school_classes');
            // tutor information
            $table->string('tutor_name', 100)->nullable(); // Assuming a tutor relationship exists
            $table->string('tutor_phone', 20)->nullable(); // Assuming a tutor relationship exists
            $table->string('tutor_email', 150)->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
}; 