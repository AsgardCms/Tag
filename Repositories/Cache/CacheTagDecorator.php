<?php

namespace Modules\Tag\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Tag\Repositories\TagRepository;

class CacheTagDecorator extends BaseCacheDecorator implements TagRepository
{
    public function __construct(TagRepository $tag)
    {
        parent::__construct();
        $this->entityName = 'tag.tags';
        $this->repository = $tag;
    }
}
