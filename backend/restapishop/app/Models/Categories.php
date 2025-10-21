<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model; // <-- dùng Model của Mongo

class Categories extends Model
{
    use HasFactory;

    // Mongo settings
    protected $connection = 'mongodb';
    protected $collection = 'categories';
    protected $primaryKey = '_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['name', 'slug'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Quan hệ: một category có nhiều product
    public function products()
    {
        // Nếu category_id trong products là ObjectId:
        return $this->hasMany(Product::class, 'category_id', '_id');

        // Nếu hiện bạn vẫn giữ id số từ MySQL (lưu ở field mysql_id trong Categories):
        // return $this->hasMany(Products::class, 'category_id', 'mysql_id');
    }
}
