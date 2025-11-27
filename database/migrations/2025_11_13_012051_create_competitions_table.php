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
        Schema::create('competitions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('image_path')->nullable();
            $table->enum('type', ['internal', 'external']); // internal = lomba di sekolah, external = lomba yang diikuti sekolah
            $table->string('organizer')->nullable(); // penyelenggara lomba
            $table->date('competition_date');
            $table->date('registration_deadline')->nullable();
            $table->text('requirements')->nullable();
            $table->text('prizes')->nullable();
            $table->string('contact_person')->nullable();
            $table->enum('status', ['upcoming', 'ongoing', 'completed'])->default('upcoming');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competitions');
    }
};
