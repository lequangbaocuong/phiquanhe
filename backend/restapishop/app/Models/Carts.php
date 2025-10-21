<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model; // <- Model của MongoDB

class Carts extends Model
{
    use HasFactory;

    // ===== Mongo settings =====
    protected $connection = 'mongodb';
    protected $collection = 'carts';
    protected $primaryKey = '_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'price',
    ];

    protected $casts = [
        'quantity'   => 'int',
        'price'      => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ===== Relationships =====
    // Nếu bạn lưu user_id/product_id là ObjectId thực sự:
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', '_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', '_id');
    }

    // Nếu hiện tại bạn đang GIỮ id số từ MySQL (map sang field mysql_id ở model kia),
    // hãy dùng:
    // public function user()   { return $this->belongsTo(User::class, 'user_id', 'mysql_id'); }
    // public function product(){ return $this->belongsTo(Products::class, 'product_id', 'mysql_id'); }
}
