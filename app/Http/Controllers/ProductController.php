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
        return Inertia::render('Product/Index', [
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
        return Inertia::render('Product/Create', [
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
                'photos.*' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            ]) + [
                'status' => 0,
                'price' => count(request()->photos) * 5
            ]
        );
        $photos = [];
        foreach (request()->file('photos') as $photo) {
            $photos[] = $photo->storeAs(
                '/images/' . $product->id,
                $photo->getClientOriginalName(),
                'local'
            );
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
                '__sizeLabel' => bytesToHuman(Storage::size(str_replace(env('APP_URL') . '/file', '', $v))),
                '__img' => [
                    'src' => route('file.show', $v)
                ]
            ];
        });

        return Inertia::render('Product/Edit', [
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
            'uploads' => ['array', 'max:5'],
            'uploads.*' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);
        $product->name = request()->name;
        $product->title = request()->title;
        $product->description = request()->description;
        $photos = [];
        // remove preview photos
        foreach (request()->get('photos', []) as $photo) {
            $filename = '/images/' . $product->id . '/' . $photo['__key'];
            if (isset($photo['__removed'])) {
                Storage::disk('local')->delete($filename);
            } else {
                $photos[] = $filename;
            }
        }
        // add upload images
        foreach (request()->file('uploads', []) as $photo) {
            $photos[] = $photo->storeAs(
                '/images/' . $product->id,
                $photo->getClientOriginalName(),
                'local'
            );
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

        return to_route('product.index', $params)->with('status', __('status.destroy'));
    }
}
