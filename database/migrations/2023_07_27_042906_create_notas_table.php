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
    Schema::create('notas', function (Blueprint $table) {
      $table->id();
      $table->string('invoice');
      $table->foreignId('customer_id');
      $table->enum('status', ['processing', 'delivered']);
      $table->text('address');
      $table->text('notes')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('notas');
  }
};
