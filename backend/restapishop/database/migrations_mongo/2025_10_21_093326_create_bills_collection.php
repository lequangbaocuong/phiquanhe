<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use MongoDB\Laravel\Schema\Blueprint as MongoBlueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mongodb')->create('bills', function (MongoBlueprint $c) {
            // _id: ObjectId mặc định

            $c->string('vn_pay_code');          // mã giao dịch VNPAY
            $c->string('product_id');           // tham chiếu product (có thể là ObjectId khi insert)
            $c->string('user_id');              // tham chiếu user (có thể là ObjectId khi insert)
            $c->double('quantity');             // hoặc integer nếu là số nguyên
            $c->double('total_amount');         // cân nhắc Decimal128 nếu cần độ chính xác cao
            $c->string('status');               // thay cho enum: 'thanh_toan_thanh_cong' | 'dang_giao_hang' | 'da_nhan'
            $c->timestamps();

            // ===== Indexes =====
            $c->unique('vn_pay_code');          // tránh trùng giao dịch
            $c->index('user_id');
            $c->index('product_id');
            $c->index('status');
            $c->index('created_at');            // lọc theo thời gian
        });
    }

    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('bills');
    }
};
