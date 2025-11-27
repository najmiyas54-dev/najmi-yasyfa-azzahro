<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->enum('review_status', ['pending_guru', 'approved_guru', 'rejected_guru', 'pending_admin', 'approved_admin', 'rejected_admin'])->default('pending_guru')->after('status');
            $table->unsignedBigInteger('reviewed_by_guru')->nullable()->after('review_status');
            $table->unsignedBigInteger('reviewed_by_admin')->nullable()->after('reviewed_by_guru');
            $table->timestamp('guru_reviewed_at')->nullable()->after('reviewed_by_admin');
            $table->timestamp('admin_reviewed_at')->nullable()->after('guru_reviewed_at');
            $table->text('guru_notes')->nullable()->after('admin_reviewed_at');
            $table->text('admin_notes')->nullable()->after('guru_notes');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['review_status', 'reviewed_by_guru', 'reviewed_by_admin', 'guru_reviewed_at', 'admin_reviewed_at', 'guru_notes', 'admin_notes']);
        });
    }
};