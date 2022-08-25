<?php

namespace App\Http\Controllers;

use Spatie\Url\Url;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Products/Index', [
            'status' => session('status'),
            'products' => QueryBuilder::for(Product::class)
                ->allowedFilters([
                    'id',
                    'name',
                    'title',
                ])
                ->allowedSorts([
                    'id',
                    'name',
                    'title',
                    'price',
                    'published_at',
                    'created_at',
                ])->paginate(request('perPage', 10))
        ]);
    }

    public function create()
    {
        return Inertia::render('Products/Create', [
            'status' => session('status'),
        ]);
    }

    public function store()
    {
        Product::create(
            request()->validate([
                'name' => ['required', "unique:products,name", 'max:100'],
            ]),
        );

        return back()->with('status', __('status.store'));
    }

    public function edit(Product $Product)
    {
        return Inertia::render('Products/Edit', [
            'status' => session('status'),
            'product' => $Product->only('id', 'name'),
        ]);
    }

    public function update(Product $Product)
    {
        $Product->update(
            request()->validate([
                'name' => ['required', "unique:products,name,{$Product->id}", 'max:100'],
            ])
        );

        return back()->with('status', __('status.update'));
    }

    public function destroy(Product $Product)
    {
        $Product->delete();
        $params = Url::fromString(url()->previous())->getAllQueryParameters();
        if (request()->last && isset($params['page'])) {
            $params['page'] = min(1, $params['page'] - 1);
        } else {
            $params['page'] = 1;
        }

        return to_route('products.index', $params)->with('status', __('status.destroy'));
    }
}
