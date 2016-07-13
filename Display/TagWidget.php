<?php

namespace Modules\Tag\Display;

use Modules\Tag\Contracts\TaggableInterface;
use Modules\Tag\Repositories\TagRepository;

class TagWidget
{
    /**
     * @var TagRepository
     */
    private $tag;
    /**
     * @var string
     */
    private $namespace;
    /**
     * @var TaggableInterface|null
     */
    private $entity;
    /**
     * @var string|null
     */
    private $view;

    public function __construct(TagRepository $tag)
    {
        $this->tag = $tag;
    }

    public function show($arguments)
    {
        $this->extractArguments($arguments);

        $view = $this->view ?: 'tag::admin.fields.tags';

        $availableTags = $this->tag->allForNamespace($this->namespace);

        return view($view, compact('availableTags'));
    }

    private function extractArguments(array $arguments)
    {
        $this->namespace = array_get($arguments, 0);
        $this->entity = array_get($arguments, 1);
        $this->view = array_get($arguments, 2);
    }
}
