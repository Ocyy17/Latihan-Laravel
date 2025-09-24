<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::create('todos', function (Blueprint $table) {
        $table->id(); // kolom id
        $table->string('title'); // judul
        $table->text('description')->nullable(); // keterangan
        $table->boolean('is_done')->default(false); // status selesai/belum
        $table->timestamp('completed_at')->nullable(); // tanggal selesai
        $table->timestamps(); // created_at & updated_at otomatis
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};
