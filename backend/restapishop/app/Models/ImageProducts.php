<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model; // dùng Model của MongoDB

class ImageProducts extends Model
{
    use HasFactory;

    // ===== Mongo settings =====
    protected $connection = 'mongodb';
    protected $collection = 'image_products';
    protected $primaryKey = '_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'product_id',
        'image',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ===== Relationships =====
    // Nếu đang lưu product_id là ObjectId thực sự:
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', '_id');
    }

    // Nếu tạm thời bạn giữ id số từ MySQL (vd. products có field mysql_id),
    // dùng bản này thay cho hàm trên:
    // public function product()
    // {
    //     return $this->belongsTo(Products::class, 'product_id', 'mysql_id');
    // }
}
