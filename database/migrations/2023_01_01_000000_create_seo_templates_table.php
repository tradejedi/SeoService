<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('seo_templates', function (Blueprint $table) {
            $table->id();
            $table->string('model_type')->nullable();
            // Если null — это глобальный шаблон для всех моделей
            // Если указано имя класса модели — шаблон только для этой модели

            $table->string('key');   // Например, 'title', 'description'
            $table->text('template'); // Строка с шаблоном: "Сайт про :name:..."

            $table->timestamps();

            $table->unique(['model_type', 'key']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('seo_templates');
    }
};
