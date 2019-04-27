<?php

/** @noinspection PhpDocMissingThrowsInspection */
/** @noinspection PhpUnhandledExceptionInspection */

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Requests\Api\Category\StoreCategoryRequest;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\CategoryCollection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return CategoryCollection
     */
    public function index()
    {
        $categories = Category::withCount('posts')->get();

        return new CategoryCollection($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreCategoryRequest  $request
     * @return CategoryResource
     */
    public function store(StoreCategoryRequest $request)
    {
        $this->authorize('create', Category::class);

        $category = Category::create($request->only('name', 'description'));

        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  Category $category
     * @return CategoryResource
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Category $category
     * @return CategoryResource
     */
    public function update(Request $request, Category $category)
    {
        $this->authorize('update', $category);

        $category->update($request->only('name', 'description'));

        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Category $category
     * @return Response
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);

        $category->delete();

        return response(null, 204);
    }
}
