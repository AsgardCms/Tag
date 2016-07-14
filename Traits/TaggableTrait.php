<?php

namespace Modules\Tag\Traits;

use Illuminate\Database\Eloquent\Builder;
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
     * Get all the entities with the given tag(s)
     * Optionally specify the column on which
     * to perform the search operation.
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string|array  $tags
     * @param  string  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereTag(Builder $query, $tags, $type = 'slug')
    {
        if (is_string($tags) === true) {
            $tags = [$tags];
        }
        $query->with('translations');

        foreach ($tags as $tag) {
            $query->whereHas('tags', function ($query) use ($type, $tag) {
                $query->whereHas('translations', function ($query) use ($type, $tag) {
                    $query->where($type, $tag);
                });
            });
        }

        return $query;
    }

    /**
     * Get all the entities with one of the given tag(s)
     * Optionally specify the column on which
     * to perform the search operation.
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string|array $tags
     * @param  string $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithTag(Builder $query, $tags, $type = 'slug')
    {
        if (is_string($tags) === true) {
            $tags = [$tags];
        }
        $query->with('translations');

        return $query->whereHas('tags', function ($query) use ($type, $tags) {
            $query->whereHas('translations', function ($query) use ($type, $tags) {
                $query->whereIn($type, $tags);
            });
        });
    }

    /**
     * Returns the entity Eloquent tag model object.
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany(static::$tagsModel, 'taggable', 'tag__tagged', 'taggable_id', 'tag_id');
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
     * Attaches or detaches the given tags.
     * @param  string|array $tags
     * @param  string $type
     * @return bool
     */
    public function setTags($tags, $type = 'slug')
    {
        // Get the current entity tags
        $entityTags = $this->tags->lists($type)->all();

        // Prepare the tags to be added and removed
        $tagsToAdd = array_diff($tags, $entityTags);
        $tagsToDel = array_diff($entityTags, $tags);

        // Detach the tags
        if (count($tagsToDel) > 0) {
            $this->untag($tagsToDel);
        }

        // Attach the tags
        if (count($tagsToAdd) > 0) {
            $this->tag($tagsToAdd);
        }

        return true;
    }

    /**
     * Attaches multiple tags to the entity.
     *
     * @param  string|array  $tags
     * @return bool
     */
    public function tag($tags)
    {
        foreach ($tags as $tag) {
            $this->addTag($tag);
        }

        return true;
    }

    /**
     * Attaches the given tag to the entity.
     * @param  string $name
     * @return void
     */
    public function addTag($name)
    {
        $tag = $this->createTagsModel()->where('namespace', $this->getEntityClassName())
            ->with('translations')
            ->whereHas('translations', function (Builder $q) use ($name) {
            $q->where('slug', $this->generateTagSlug($name));
        })->first();

        if ($tag === null) {
            $tag = new Tag([
                'namespace' => $this->getEntityClassName(),
                locale() => [
                    'slug' => $this->generateTagSlug($name),
                    'name' => $name,
                ],
            ]);
        }
        if ($tag->exists === false) {
            $tag->save();
        }

        if ($this->tags->contains($tag->id) === false) {
            $this->tags()->attach($tag);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function untag($tags = null)
    {
        $tags = $tags ?: $this->tags->lists('name')->all();

        foreach ($tags as $tag) {
            $this->removeTag($tag);
        }

        return true;
    }

    /**
     * Detaches the given tag from the entity.
     * @param string $name
     * @return void
     */
    public function removeTag($name)
    {
        $tag = $this->createTagsModel()
            ->where('namespace', $this->getEntityClassName())
            ->with('translations')
            ->whereHas('translations', function (Builder $q) use ($name) {
                $q->orWhere('name', $this->generateTagSlug($name));
                $q->orWhere('slug', $this->generateTagSlug($name));
            })->first();

        if ($tag) {
            $this->tags()->detach($tag);
        }
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

    /**
     * Generate the tag slug using the given name.
     * @param string $name
     * @return string
     */
    protected function generateTagSlug($name)
    {
        return str_slug($name);
    }
}
