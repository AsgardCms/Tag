<?php

namespace Modules\Tag\Traits;

use Modules\Tag\Entities\Tag;

trait TaggableTrait
{
    /**
     * The Eloquent tags model name.
     *
     * @var string
     */
    protected static $tagsModel = Tag::class;

    /**
     * Returns the Eloquent tags model name.
     * @return string
     */
    public static function getTagsModel()
    {
        return static::$tagsModel;
    }

    /**
     * Sets the Eloquent tags model name.
     * @param string $model
     * @return void
     */
    public static function setTagsModel($model)
    {
        static::$tagsModel = $model;
    }

    /**
     * Returns the entity Eloquent tag model object.
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany(static::$tagsModel, 'taggable', 'tagged', 'taggable_id', 'tag_id');
    }

    /**
     * Creates a new model instance.
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function createTagsModel()
    {
        return new static::$tagsModel;
    }

    /**
     * Returns all the tags under the entity namespace.
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function allTags()
    {
        $instance = new static;

        return $instance->createTagsModel()->with('translations')->whereNamespace($instance->getEntityClassName());
    }

    /**
     * Returns the entity class name.
     *
     * @return string
     */
    protected function getEntityClassName()
    {
        if (isset(static::$entityNamespace)) {
            return static::$entityNamespace;
        }

        return $this->tags()->getMorphClass();
    }
}
