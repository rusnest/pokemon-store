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
            'users', function (Blueprint $table) {
                $table->uuid('id');
                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->string('display_name')->nullable();
                $table->string('email')->unique()->nullable();;
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password')->nullable();
                $table->string('profile_image')->nullable();
                $table->string('google_id')->nullable();
                $table->uuid('refferal_user_id')->nullable();
                $table->enum('account_type', ['admin', 'individual'])->nullable();
                $table->primary('id');
                $table->softDeletes();
                $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
