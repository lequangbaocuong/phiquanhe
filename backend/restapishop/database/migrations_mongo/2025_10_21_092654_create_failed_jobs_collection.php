<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use MongoDB\Laravel\Schema\Blueprint as MongoBlueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mongodb')->create('failed_jobs', function (MongoBlueprint $c) {
            // _id: ObjectId mặc định của MongoDB

            // Các field tương tự MySQL
            $c->string('uuid');                 // unique bên dưới
            $c->string('connection');           // text ở MySQL -> string ở Mongo là đủ
            $c->string('queue');                // tương tự
            $c->longText('payload');            // có thể dùng longText/string; Mongo lưu BSON string, không giới hạn 64KB như MySQL
            $c->longText('exception');          // tương tự
            $c->timestamp('failed_at')->useCurrent(); // tương đương useCurrent()

            // Indexes
            $c->unique('uuid');
            $c->index('failed_at');             // tra cứu theo thời gian nhanh hơn

            // (Tuỳ chọn) TTL tự xoá job fail sau 30 ngày:
            // $c->index('failed_at', null, null, ['expireAfterSeconds' => 2592000]);
        });
    }

    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('failed_jobs');
    }
};
