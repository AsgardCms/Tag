<?php

namespace Modules\Tag\Tests;

use Modules\Tag\Contracts\TaggableInterface;
use Modules\Tag\Repositories\TagManager;
use Modules\Tag\Traits\NamespacedEntity;
use Modules\Tag\Traits\TaggableTrait;

class TagManagerRepositoryTest extends BaseTestCase
{
    /**
     * @var TagManager
     */
    private $tagManager;

    public function setUp()
    {
        parent::setUp();

        $this->tagManager = app(TagManager::class);
    }

    /** @test */
    public function it_initialises_empty_array()
    {
        $this->assertEquals([], $this->tagManager->getNamespaces());
    }

    /** @test */
    public function it_adds_items_to_array()
    {
        $this->tagManager->registerNamespace(new TestModel());

        $this->assertCount(1, $this->tagManager->getNamespaces());
    }
}

class TestModel implements TaggableInterface
{
    use TaggableTrait, NamespacedEntity;
    protected static $entityNamespace = 'asgardcms/media';
}
