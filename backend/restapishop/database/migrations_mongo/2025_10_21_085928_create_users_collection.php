<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use MongoDB\Laravel\Schema\Blueprint as MongoBlueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mongodb')->create('users', function (MongoBlueprint $collection) {
            // _id là ObjectId mặc định (không dùng $table->id())

            $collection->string('name');
            $collection->string('email');
            $collection->timestamp('email_verified_at')->nullable();
            $collection->string('password');
            $collection->string('avatar');
            $collection->boolean('is_admin')->default(false);
            $collection->string('github_id')->nullable();
            $collection->string('google_id')->nullable();
            $collection->string('fcm_id')->nullable();
            $collection->string('auth_type');
            $collection->string('remember_token')->nullable();

            $collection->timestamps();

            // Index tương đương logic cũ
            $collection->unique('email');
            // $collection->unique('github_id', null, null, ['sparse' => true]);
            // $collection->unique('google_id', null, null, ['sparse' => true]);
            // $collection->index('auth_type');
        });
    }

    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('users');
    }
};
