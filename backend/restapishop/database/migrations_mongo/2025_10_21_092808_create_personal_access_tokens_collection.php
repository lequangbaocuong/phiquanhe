<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use MongoDB\Laravel\Schema\Blueprint as MongoBlueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mongodb')->create('personal_access_tokens', function (MongoBlueprint $c) {
            // _id: ObjectId mặc định

            // morphs('tokenable') tương đương 2 cột:
            $c->string('tokenable_type');     // ví dụ: App\Models\User
            $c->string('tokenable_id');       // ID của model (giữ dạng string để linh hoạt)

            $c->string('name');
            $c->string('token', 64);          // unique bên dưới
            $c->text('abilities')->nullable();
            $c->timestamp('last_used_at')->nullable();
            $c->timestamp('expires_at')->nullable();
            $c->timestamps();

            // ===== Indexes =====
            $c->unique('token');                                // giống unique token ở MySQL
            $c->index(['tokenable_type', 'tokenable_id']);      // tra cứu theo chủ sở hữu token
            // (Tuỳ chọn) TTL tự xoá token khi hết hạn:
            // $c->index('expires_at', null, null, ['expireAfterSeconds' => 0]);
        });
    }

    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('personal_access_tokens');
    }
};
