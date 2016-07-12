<?php

namespace Modules\Tag\Contracts;

interface TaggableInterface
{
    /**
     * Returns the entity namespace.
     * @return string
     */
    public static function getEntityNamespace();

    /**
     * Returns the Eloquent tags model name.
     * @return string
     */
    public static function getTagsModel();

    /**
     * Sets the Eloquent tags model name.
     * @param  string $model
     * @return void
     */
    public static function setTagsModel($model);

    /**
     * Returns the entity Eloquent tag model object.
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tags();

    /**
     * Returns all the tags under the entity namespace.
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function allTags();

    /**
     * Creates a new model instance.
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function createTagsModel();
}
