<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use MongoDB\Laravel\Schema\Blueprint as MongoBlueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mongodb')->create('password_reset_tokens', function (MongoBlueprint $c) {
            // Mongo có _id mặc định (ObjectId). Ta giữ _id mặc định
            // và đảm bảo mỗi email chỉ có 1 token bằng unique index.

            $c->string('email');        // unique bên dưới
            $c->string('token');
            $c->timestamp('created_at')->nullable();

            // === Indexes ===
            $c->unique('email');        // tương đương PRIMARY KEY(email) ở MySQL

            // (Tuỳ chọn) TTL để tự xoá token sau 60 phút:
            // $c->index('created_at', null, null, ['expireAfterSeconds' => 3600]);
        });
    }

    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('password_reset_tokens');
    }
};
