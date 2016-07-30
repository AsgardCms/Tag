<?php

namespace Modules\Tag\Blade\Facade;

use Illuminate\Support\Facades\Facade;

class TagWidget extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'tag.widget.directive';
    }
}
