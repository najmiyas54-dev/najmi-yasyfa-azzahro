<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'category',
        'location',
        'image_path',
        'status',
        'review_status',
        'approval_status',
        'user_id',
        'views_count',
        'likes_count',

        'reviewed_by_guru',
        'reviewed_by_admin',
        'guru_reviewed_at',
        'admin_reviewed_at',
        'guru_approved_at',
        'admin_approved_at',
        'guru_notes',
        'admin_notes',
        'is_published',
        'published_at',
        'posted_date',
        'file_path',
        'author_name'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'guru_reviewed_at' => 'datetime',
        'admin_reviewed_at' => 'datetime',
        'guru_approved_at' => 'datetime',
        'admin_approved_at' => 'datetime',
        'published_at' => 'datetime',
        'posted_date' => 'datetime',
        'is_published' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }



    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function isLikedBy($userIdOrIp = null)
    {
        if (is_null($userIdOrIp)) {
            if (auth()->check()) {
                return $this->likes()->where('user_id', auth()->id())->exists();
            } else {
                return $this->likes()->where('ip_address', request()->ip())->exists();
            }
        }
        
        if (is_numeric($userIdOrIp) && $userIdOrIp > 0) {
            return $this->likes()->where('user_id', $userIdOrIp)->exists();
        } else {
            return $this->likes()->where('ip_address', $userIdOrIp)->exists();
        }
    }



    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopePendingReview($query)
    {
        return $query->where('approval_status', 'pending');
    }

    public function scopeApprovedByGuru($query)
    {
        return $query->where('approval_status', 'approved_by_guru');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => '<span class="badge bg-warning">Menunggu Review</span>',
            'approved_by_guru' => '<span class="badge bg-info">Disetujui Guru</span>',
            'approved_by_admin' => '<span class="badge bg-success">Disetujui Admin</span>',
            'published' => '<span class="badge bg-success">Dipublikasi</span>',
            'rejected' => '<span class="badge bg-danger">Ditolak</span>'
        ];
        
        return $badges[$this->approval_status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }

    /**
     * Delete all files associated with this post
     */
    public function deleteFiles()
    {
        // Delete image file
        if ($this->image_path && \Storage::exists('public/' . $this->image_path)) {
            \Storage::delete('public/' . $this->image_path);
        }
        
        // Delete document file (PDF, DOC, etc.)
        if ($this->file_path && \Storage::exists('public/' . $this->file_path)) {
            \Storage::delete('public/' . $this->file_path);
        }
    }

    /**
     * Boot method to handle model events
     */
    protected static function boot()
    {
        parent::boot();
        
        // Automatically delete files when post is deleted
        static::deleting(function ($post) {
            $post->deleteFiles();
        });
    }
}