<?php

namespace App\Http\Controllers;

use Spatie\Url\Url;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
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
        $product = Product::create(
            request()->validate([
                'name' => ['required', "unique:products,name", 'max:100'],
                'title' => ['required', 'max:100'],
                'description' => ['required', 'max:100'],
                'photos' => ['required', 'array', 'max:5'],
            ]) + [
                'status' => 0,
                'price' => count(request()->photos) * 5
            ]
        );
        $photos = [];
        foreach (request()->file('photos') as $photo) {
            $path = $photo->store('/images/' . $product->name, ['disk' =>   'local']);
            $photos[] = route('files.show', $path);
        }
        $product->photos = $photos;
        $product->save();

        return back()->with('status', __('status.store'));
    }

    public function edit(Product $product)
    {
        $product->photos = Arr::map($product->photos, function ($v) {
            $filename = Arr::last(explode('/', $v));

            return [
                '__key' => $filename,
                'name' => $filename,
                '__sizeLabel' => bytesToHuman(Storage::size(str_replace(env('APP_URL') . '/files', '', $v))),
                '__img' => [
                    'src' => $v
                ]
            ];
        });

        return Inertia::render('Products/Edit', [
            'status' => session('status'),
            'product' => $product,
        ]);
    }

    public function update(Product $product)
    {
        request()->validate([
            'name' => ['required', "unique:products,name,{$product->id}", 'max:100'],
            'title' => ['required', 'max:100'],
            'description' => ['required', 'max:100'],
            'photos' => ['array', 'max:5'],
            'preview' => ['array', 'max:5'],
        ]);
        $product->name = request()->name;
        $product->title = request()->title;
        $product->description = request()->description;
        $photos = $product->photos;
        foreach (request()->get('preview', []) as $photo) {
            if (isset($photo['__removed'])) {
                $pos = array_search($photo['__img']['src'], $photos);
                if ($pos !== false) {
                    array_splice($photos, $pos, 1);
                    Storage::disk('local')->delete('/images/' . $product->name . '/' . $photo['__key']);
                }
            }
        }
        foreach (request()->file('photos', []) as $photo) {
            $path = $photo->store('/images/' . $product->name, ['disk' =>   'local']);
            $photos[] = route('files.show', $path);
        }
        $product->photos = $photos;
        $product->save();

        return back()->with('status', __('status.update'));
    }

    public function destroy(Product $product)
    {
        Storage::deleteDirectory('images/' . $product->name);
        $product->delete();
        $params = Url::fromString(url()->previous())->getAllQueryParameters();
        if (request()->last && isset($params['page'])) {
            $params['page'] = min(1, $params['page'] - 1);
        } else {
            $params['page'] = 1;
        }

        return to_route('products.index', $params)->with('status', __('status.destroy'));
    }
}
