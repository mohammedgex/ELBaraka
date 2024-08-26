<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('buses', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->json('images'); // صور الباص
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            // $table->integer('route_id');
            // $table->unsignedBigInteger('route_id'); // تأكد من وجود جدول routes مع هذا العمود
            $table->integer('capacity');
            $table->integer('luggage_capacity');
            $table->integer('max_speed');
            $table->boolean('is_available');
            $table->json('features'); // مميزات الباص
            $table->timestamps();
            // تعريف المفاتيح الأجنبية
            // $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            // $table->foreign('route_id')->references('id')->on('routes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('buses');
    }
};
