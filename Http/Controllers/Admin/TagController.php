<?php

namespace Modules\Tag\Http\Controllers\Admin;

use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Tag\Entities\Tag;
use Modules\Tag\Http\Requests\CreateTagRequest;
use Modules\Tag\Http\Requests\UpdateTagRequest;
use Modules\Tag\Repositories\TagManager;
use Modules\Tag\Repositories\TagRepository;

class TagController extends AdminBaseController
{
    /**
     * @var TagRepository
     */
    private $tag;

    public function __construct(TagRepository $tag)
    {
        parent::__construct();

        $this->tag = $tag;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $tags = $this->tag->all();

        return view('tag::admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(TagManager $tagManager)
    {
        dd($tagManager->getNamespaces());

        return view('tag::admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateTagRequest $request
     * @return Response
     */
    public function store(CreateTagRequest $request)
    {
        $this->tag->create($request->all());

        return redirect()->route('admin.tag.tag.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('tag::tags.tags')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Tag $tag
     * @return Response
     */
    public function edit(Tag $tag)
    {
        return view('tag::admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Tag $tag
     * @param  UpdateTagRequest $request
     * @return Response
     */
    public function update(Tag $tag, UpdateTagRequest $request)
    {
        $this->tag->update($tag, $request->all());

        return redirect()->route('admin.tag.tag.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('tag::tags.tags')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Tag $tag
     * @return Response
     */
    public function destroy(Tag $tag)
    {
        $this->tag->destroy($tag);

        return redirect()->route('admin.tag.tag.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('tag::tags.tags')]));
    }
}
