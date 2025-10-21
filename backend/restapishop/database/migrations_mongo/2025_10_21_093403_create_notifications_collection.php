<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use MongoDB\Laravel\Schema\Blueprint as MongoBlueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mongodb')->create('notifications', function (MongoBlueprint $c) {
            // _id: ObjectId mặc định

            $c->string('type');          // 'success' | 'error' | 'warning' | 'info' (validate ở app)
            $c->string('user_id');       // tham chiếu user (có thể lưu ObjectId trong code)
            $c->text('data');            // JSON/string payload
            $c->timestamp('read_at')->nullable();
            $c->timestamps();

            // ===== Indexes =====
            $c->index('user_id');                 // truy vấn notif của user
            $c->index('type');                    // lọc theo loại
            $c->index('created_at');              // sort/ lọc theo thời gian
            $c->index('read_at', null, null, ['sparse' => true]); // unread filter nhanh (read_at null)
        });
    }

    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('notifications');
    }
};
