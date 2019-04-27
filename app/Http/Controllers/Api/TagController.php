<?php

/** @noinspection PhpDocMissingThrowsInspection */
/** @noinspection PhpUnhandledExceptionInspection */

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tag;
use App\Http\Resources\{
    Tag as TagResource,
    TagCollection
};
use App\Http\Requests\Api\Tag\{
    StoreTagRequest,
    UpdateTagRequest
};

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return TagCollection
     */
    public function index()
    {
        return new TagCollection(Tag::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreTagRequest  $request
     * @return TagResource
     */
    public function store(StoreTagRequest $request)
    {
        $tag = Tag::create($request->only('name'));

        return new TagResource($tag);
    }

    /**
     * Display the specified resource.
     *
     * @param  Tag $tag
     * @return TagResource
     */
    public function show(Tag $tag)
    {
        $tag->load('posts');

        return new TagResource($tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateTagRequest  $request
     * @param  Tag $tag
     * @return TagResource
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $this->authorize('update', $tag);

        $tag->update($request->only('name'));

        return new TagResource($tag);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Tag $tag
     * @return Response
     */
    public function destroy(Tag $tag)
    {
        $this->authorize('delete', $tag);

        $tag->delete();

        return response(null, 204);
    }
}
