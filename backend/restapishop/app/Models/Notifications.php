<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model; // <- Model của MongoDB
use Illuminate\Database\Eloquent\Builder;

class Notifications extends Model
{
    use HasFactory;

    // ===== Mongo settings =====
    protected $connection = 'mongodb';
    protected $collection = 'notifications';
    protected $primaryKey = '_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'type',      // 'success' | 'error' | 'warning' | 'info' (validate ở FormRequest)
        'data',      // JSON/string payload
        'read_at',
    ];

    protected $casts = [
        'read_at'   => 'datetime',
        'created_at'=> 'datetime',
        'updated_at'=> 'datetime',
    ];

    // ===== Quan hệ =====
    // Nếu bạn đang lưu user_id là ObjectId:
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', '_id');
    }

    // Nếu hiện vẫn giữ id số từ MySQL (ví dụ lưu vào field mysql_id ở User):
    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id', 'mysql_id');
    // }

    // ===== Scopes tiện dụng =====
    public function scopeUnread(Builder $q): Builder
    {
        return $q->whereNull('read_at');
    }

    public function scopeForUser(Builder $q, $userId): Builder
    {
        return $q->where('user_id', $userId);
    }

    // ===== Helpers =====
    public function markAsRead(): void
    {
        $this->read_at = now();
        $this->save();
    }

    public function getIsReadAttribute(): bool
    {
        return !is_null($this->read_at);
    }
}
