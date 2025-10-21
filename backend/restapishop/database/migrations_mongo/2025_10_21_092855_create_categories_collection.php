<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use MongoDB\Laravel\Schema\Blueprint as MongoBlueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mongodb')->create('categories', function (MongoBlueprint $c) {
            // _id: ObjectId mặc định của MongoDB

            $c->string('name');
            $c->string('slug');     // unique bên dưới
            $c->timestamps();

            // Indexes tương đương logic MySQL
            $c->unique('slug');
            // (tuỳ chọn) nếu hay lọc theo created_at:
            // $c->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('categories');
    }
};
