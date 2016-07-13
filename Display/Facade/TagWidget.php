<?php

namespace Modules\Tag\Display\Facade;

use Illuminate\Support\Facades\Facade;

class TagWidget extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'tag.widget';
    }
}
