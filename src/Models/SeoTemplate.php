<?php

namespace CoolmacJedi\SeoService\Models;

use Illuminate\Database\Eloquent\Model;

class SeoTemplate extends Model
{
    protected $table = 'seo_templates';

    protected $fillable = [
        'model_type',
        'key',
        'template',
    ];
}
