<?php

namespace TradeJedi\SeoService\Models;

use Illuminate\Database\Eloquent\Model;

class SeoTag extends Model
{
    protected $table = 'seo_tags';

    protected $fillable = [
        'model_type',
        'model_id',
        'key',
        'value',
    ];
}
