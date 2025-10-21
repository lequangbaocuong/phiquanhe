<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model; // <— dùng Model của MongoDB

class Bills extends Model
{
    use HasFactory;

    // KHAI BÁO MONGO
    protected $connection = 'mongodb';
    protected $collection = 'bills';
    protected $primaryKey = '_id';
    public $incrementing = false;
    protected $keyType = 'string';

    // Trường cho phép fill
    protected $fillable = [
        'vn_pay_code',
        'user_id',
        'product_id',
        'quantity',
        'total_amount',
        'status',
    ];

    // Ép kiểu tiện cho tính toán/lọc
    protected $casts = [
        'quantity'     => 'int',    // nếu bạn dùng số nguyên
        'total_amount' => 'float',  // hoặc 'decimal:2' nếu muốn
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
    ];

    // (Tuỳ chọn) hằng số cho status thay enum
    public const STATUS_PAID    = 'thanh_toan_thanh_cong';
    public const STATUS_SHIP    = 'dang_giao_hang';
    public const STATUS_DONE    = 'da_nhan';

    // ===== Quan hệ =====
    // Nếu bạn đang LƯU user_id/product_id là ObjectId của Mongo:
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', '_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', '_id');
    }

    // Nếu hiện tại bạn vẫn giữ ID kiểu số (id MySQL cũ), đổi 2 hàm trên thành:
    // return $this->belongsTo(User::class, 'user_id', 'mysql_id');
    // return $this->belongsTo(Products::class, 'product_id', 'mysql_id');
}
