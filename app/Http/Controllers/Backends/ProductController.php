<?php

namespace App\Http\Controllers\Backends;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->when(
            request()->q,
            function ($products) {
                // $products = $products->where('title', 'like', '%' . request()->q . '%');
                $products = $products->where(function ($query) {
                    $query->where('title', 'like', '%' . request()->q . '%')
                        ->orWhere('description', 'like', '%' . request()->q . '%');
                });
            }
        )->orderBy('id', 'desc')->paginate(10);
        return view('backends.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backends.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate(
            [
                'title' => 'required',
                'description' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'weight' => 'required',
                'price' => 'required',
            ],
            [
                'title.required' => 'Judul wajib diisi!',
                'description.required' => 'Deskripsi wajib diisi!',
                'image.required' => 'Gambar wajib diisi!',
                'image.image' => 'Gambar harus berupa gambar!',
                'image.mimes' => 'Gambar harus berformat jpeg, png, jpg, gif, svg!',
                'image.max' => 'Ukuran gambar maksimal 2MB!',
                'weight.required' => 'Berat wajib diisi!',
                'price.required' => 'Harga wajib diisi!',
            ]
        );

        // membuat slug dari title
        $slug = Str::slug($request->title);

        // Cek status show atau hide
        $status = $request->has('status') ? 'show' : 'hide';

        // menyimpan gambar ke dalam folder storage/products
        $image = $request->file('image');
        $image_name = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('storage/products'), $image_name);

        // menyimpan data products ke dalam database
        Product::create([
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'image' => $image_name,
            'weight' => $request->weight,
            'price' => $request->price,
            'status' => $status,
        ]);

        if ($request) {
            toastr()
                ->positionClass('toast-top-center')
                ->success('Data product berhasil ditambahkan!');
            return redirect()->route('admin.products.index');
        } else {
            toastr()
                ->positionClass('toast-top-center')
                ->error('Data product gagal ditambahkan!');
            return redirect()->route('admin.products.create');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('backends.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate(
            [
                'title' => 'required',
                'description' => 'required',
                // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'weight' => 'required',
                'price' => 'required',
            ],
            [
                'title.required' => 'Judul wajib diisi!',
                'description.required' => 'Deskripsi wajib diisi!',
                // 'image.required' => 'Gambar wajib diisi!',
                // 'image.image' => 'Gambar harus berupa gambar!',
                // 'image.mimes' => 'Gambar harus berformat jpeg, png, jpg, gif, svg!',
                // 'image.max' => 'Ukuran gambar maksimal 2MB!',
                'weight.required' => 'Berat wajib diisi!',
                'price.required' => 'Harga wajib diisi!',
            ]
        );

        // membuat slug dari title
        $slug = Str::slug($request->title);

        // Cek status show atau hide
        $status = $request->has('status') ? 'show' : 'hide';

        if ($request->hasFile('image')) {

            // hapus gambar lama di dalam folder storage/products
            $oldImage = public_path('storage/products/' . $product->image);
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }

            // menyimpan gambar ke dalam folder storage/products
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/products'), $image_name);

            // menyimpan data products ke dalam database
            Product::where('id', $product->id)->update([
                'title' => $request->title,
                'slug' => $slug,
                'description' => $request->description,
                'image' => $image_name,
                'weight' => $request->weight,
                'price' => $request->price,
                'status' => $status,
            ]);
        } else {
            // menyimpan data products ke dalam database tanpa mengubah gambar
            Product::where('id', $product->id)->update([
                'title' => $request->title,
                'slug' => $slug,
                'description' => $request->description,
                'weight' => $request->weight,
                'price' => $request->price,
                'status' => $status,
            ]);
        }

        if ($request) {
            toastr()
                ->positionClass('toast-top-center')
                ->success('Data product berhasil diubah!');
            return redirect()->route('admin.products.index');
        } else {
            toastr()
                ->positionClass('toast-top-center')
                ->error('Data product gagal diubah!');
            return redirect()->route('admin.products.edit', $product->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if (file_exists(public_path('storage/products/' . $product->image))) {
            unlink(public_path('storage/products/' . $product->image));
        }

        Product::destroy('id', $product->id);

        if ($product) {
            toastr()
                ->positionClass('toast-top-center')
                ->success('Data product berhasil dihapus!');
            return redirect()->route('admin.products.index');
        } else {
            toastr()
                ->positionClass('toast-top-center')
                ->error('Data product gagal dihapus!');
            return redirect()->route('admin.products.index');
        }
    }
}
