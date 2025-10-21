<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;        // <- Model của MongoDB
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    // ===== Mongo settings =====
    protected $connection = 'mongodb';
    protected $collection = 'products';
    protected $primaryKey = '_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'sale_price',
        'slug',
        'category_id',
    ];

    protected $casts = [
        'price'      => 'float',
        'sale_price' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ===== Quan hệ =====
    // Nếu category_id đang lưu ObjectId thực sự:
    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id', '_id');
    }

    // Nếu tạm thời bạn giữ id số (id MySQL cũ) trong field category_id:
    // public function category()
    // {
    //     return $this->belongsTo(Categories::class, 'category_id', 'mysql_id');
    // }

    public function images()
    {
        return $this->hasMany(ImageProducts::class, 'product_id', '_id'); // hoặc 'mysql_id' nếu giữ id số
    }

    // ===== Hooks =====
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Product $product) {
            $product->slug = $product->slug
                ? Str::slug($product->slug)
                : Str::slug((string) $product->name);
        });

        static::updating(function (Product $product) {
            if ($product->isDirty('name') || $product->isDirty('slug')) {
                $product->slug = $product->slug
                    ? Str::slug($product->slug)
                    : Str::slug((string) $product->name);
            }
        });
    }
}
