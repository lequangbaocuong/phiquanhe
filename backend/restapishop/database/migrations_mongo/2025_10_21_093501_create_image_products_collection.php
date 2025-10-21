<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use MongoDB\Laravel\Schema\Blueprint as MongoBlueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mongodb')->create('image_products', function (MongoBlueprint $c) {
            // _id: ObjectId mặc định

            // Tham chiếu product (nếu thực tế bạn dùng ObjectId, khi insert nhớ truyền ObjectId)
            $c->string('product_id');

            $c->string('image');
            $c->timestamps();

            // ===== Indexes =====
            $c->index('product_id');                     // truy vấn ảnh theo sản phẩm
            // Tránh trùng cùng 1 ảnh cho 1 product (tuỳ nhu cầu):
            // $c->unique(['product_id', 'image']);
            $c->index('created_at');                     // sort/ lọc theo thời gian
        });
    }

    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('image_products');
    }
};
