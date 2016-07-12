<?php

namespace Modules\Tag\Contracts;

interface TaggableInterface
{
    /**
     * Returns the entity namespace.
     * @return string
     */
    public static function getEntityNamespace();
}
