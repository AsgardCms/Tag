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

    /**
     * Attaches or detaches the given tags.
     * @param  string|array $tags
     * @param  string $type
     * @return bool
     */
    public function setTags($tags, $type = 'name');

    /**
     * Detaches multiple tags from the entity or if no tags are
     * passed, removes all the attached tags from the entity.
     * @param  string|array|null $tags
     * @return bool
     */
    public function untag($tags = null);

    /**
     * Detaches the given tag from the entity.
     * @param  string  $name
     * @return void
     */
    public function removeTag($name);

    /**
     * Attaches multiple tags to the entity.
     *
     * @param  string|array  $tags
     * @return bool
     */
    public function tag($tags);

    /**
     * Attaches the given tag to the entity.
     * @param  string $name
     * @return void
     */
    public function addTag($name);
}
