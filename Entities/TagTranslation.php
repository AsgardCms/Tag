<?php

namespace Modules\Tag\Entities;

use Illuminate\Database\Eloquent\Model;

class TagTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'tag__tag_translations';
}
