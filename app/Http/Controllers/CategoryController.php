<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * @param Request $request
     * @return CategoryCollection
     */
    public function index(Request $request)
    {
        $request->validate([
            'sortBy'=>['sometimes','in:slug,title'],
            'desc'=>['boolean']
        ]);

        $categories = Category::query()
            ->when($request->filled('sorBy'), function ($query)use($request){
                $query->orderBy($request->input('sortBy'),$request->input('desc')?'desc':'asc');
            })
            ->paginate();

        return new CategoryCollection($categories);
    }

    /**
     * @param Request $request
     * @return CategoryResource
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'slug' => ['required', Rule::unique(Category::query()->getTable())],
        ]);

        $category = Category::create([
            'uuid' => Str::uuid(),
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
        ]);

        return new CategoryResource($category);
    }

    /**
     * @param Category $category
     * @return CategoryResource
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * @param Request $request
     * @param Category $category
     * @return CategoryResource
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'title' => ['required'],
            'slug' => ['required', Rule::unique(Category::query()->getTable())->ignore($category->id)]
        ]);

        $category->fill([
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
        ])->save();

        return new CategoryResource($category);
    }

    /**
     * @param Category $category
     * @return Response
     */
    public function destroy(Category $category)
    {
        if(!$category->delete()){
            return \response([
                'message' => 'Unable to deleted Category.'
            ],'400');
        }

        return \response([
            'message' => 'Category has been deleted successfully.'
        ]);
    }
}
