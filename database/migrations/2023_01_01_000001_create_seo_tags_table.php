<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('seo_tags', function (Blueprint $table) {
            $table->id();
            $table->string('model_type');           // Класс модели, например App\Models\Post
            $table->unsignedBigInteger('model_id'); // ID записи в этой модели
            $table->string('key');                  // SEO-ключ (title, description и т.д.)
            $table->text('value');                  // Конкретное значение, если переопределено

            $table->timestamps();

            $table->index(['model_type', 'model_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('seo_tags');
    }
};
