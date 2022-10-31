<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'login_tokens', function (Blueprint $table) {
                $table->uuid('id');
                $table->uuid('user_id');
                $table->string('token')->unique();
                $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
                $table->timestamp('consumed_at')->nullable();
                $table->timestamp('expires_at');
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('login_tokens');
    }
};
