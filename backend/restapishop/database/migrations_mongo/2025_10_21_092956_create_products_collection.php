<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use MongoDB\Laravel\Schema\Blueprint as MongoBlueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mongodb')->create('products', function (MongoBlueprint $c) {
            // _id: ObjectId mặc định

            // Tham chiếu category: lưu category_id và tạo index để truy vấn nhanh
            // Nếu bạn dùng ObjectId thực sự, vẫn cứ lưu ObjectId được; schema này chỉ "gợi ý".
            $c->string('category_id');   // hoặc lưu ObjectId trong thực tế

            $c->string('name');
            $c->string('slug');          // unique bên dưới
            $c->text('description')->nullable();
            $c->string('image')->nullable();

            // Giá: nên dùng double hoặc Decimal128 (nếu cần độ chính xác cao)
            $c->double('price');
            $c->double('sale_price')->nullable();

            $c->timestamps();

            // ===== Indexes =====
            $c->unique('slug');
            $c->index('category_id');
            $c->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('products');
    }
};
