<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('prestasi', function (Blueprint $table) {
            $table->string('file_path')->nullable()->after('image_path');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('is_active');
            $table->text('admin_notes')->nullable()->after('status');
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
        });
    }

    public function down()
    {
        Schema::table('prestasi', function (Blueprint $table) {
            $table->dropColumn(['file_path', 'status', 'admin_notes', 'user_id']);
        });
    }
};