<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->enum('approval_status', ['draft', 'pending', 'approved_by_guru', 'approved_by_admin', 'published', 'rejected'])->default('pending');
            $table->timestamp('guru_approved_at')->nullable();
            $table->timestamp('admin_approved_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['approval_status', 'guru_approved_at', 'admin_approved_at']);
        });
    }
};