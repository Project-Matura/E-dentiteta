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
        Schema::create('request_card', function (Blueprint $table) {
            $table->uuid('id_request_card')->primary();
            $table->uuid('id_user');
            $table->uuid('id_card');
            $table->uuid('id_organisation');
            $table->string('status')->default('pending');

            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_card')->references('id')->on('cards')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_organisation')->references('id')->on('organisations')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_card');
    }
};
