<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use MongoDB\Laravel\Schema\Blueprint as MongoBlueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mongodb')->create('carts', function (MongoBlueprint $c) {
            // _id: ObjectId mặc định

            // Nếu bên bạn dùng ObjectId thật cho user/product, có thể lưu kiểu ObjectId khi insert.
            // Ở migration, ta cứ khai báo string để linh hoạt:
            $c->string('product_id');
            $c->string('user_id');

            $c->integer('quantity');
            $c->double('price'); // hoặc Decimal128 nếu cần chính xác cao

            $c->timestamps();

            // ===== Indexes =====
            // Tối ưu truy vấn theo user:
            $c->index('user_id');
            // Tối ưu join tay theo product:
            $c->index('product_id');
            // Tránh 1 user thêm trùng 1 product nhiều dòng:
            $c->unique(['user_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('carts');
    }
};
