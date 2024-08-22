<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_id')->index();
            $table->foreignId('member_id');
            $table->foreignId('bank_id')->nullable();
            $table->foreignId('member_account_id')->nullable();
            $table->foreignId('account_id');
            $table->foreignId('website_id');
            $table->boolean('new');
            $table->integer('amount');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
