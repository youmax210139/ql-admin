<?php

namespace App\Http\Controllers;

use Spatie\Url\Url;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return Inertia::render('Categories/Index', [
            'status' => session('status'),
            'categories' => QueryBuilder::for(Category::class)
                ->allowedFilters([
                    'id',
                    'name',
                    'created_at',
                ])
                ->allowedSorts([
                    'id',
                    'name',
                    'created_at',
                ])->paginate(request('perPage', 10))
        ]);
    }

    public function create()
    {
        return Inertia::render('Categories/Create', [
            'status' => session('status'),
        ]);
    }

    public function store()
    {
        Category::create(
            request()->validate([
                'name' => ['required', "unique:categories,name", 'max:100'],
            ]),
        );

        return back()->with('status', __('status.store'));
    }

    public function edit(Category $category)
    {
        return Inertia::render('Categories/Edit', [
            'status' => session('status'),
            'category' => $category->only('id', 'name'),
        ]);
    }

    public function update(Category $category)
    {
        $category->update(
            request()->validate([
                'name' => ['required', "unique:categories,name,{$category->id}", 'max:100'],
            ])
        );

        return back()->with('status', __('status.update'));
    }

    public function destroy(Category $category)
    {
        $category->delete();
        $params = Url::fromString(url()->previous())->getAllQueryParameters();
        if (request()->last) {
            $params['page'] = min(1, $params['page'] - 1);
        }

        return to_route('categories.index', $params)->with('status', __('status.destroy'));
    }
}
