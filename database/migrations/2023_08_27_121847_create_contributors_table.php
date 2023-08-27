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
        Schema::create('contributors', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger(("collection_id"));

            $table->unsignedBigInteger("user_id");

            $table->decimal("amount");

            $table->foreign('user_id')
                ->references('id')->on('users');
            $table->foreign('collection_id')
                ->references('id')->on('collections');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contributors');
    }
};
