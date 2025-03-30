<?php

namespace App\Http\Controllers;
// import model product
use App\Models\Product;
// import return type redirectResponse
use Illuminate\Http\RedirectResponse;
// import Http Request
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
// import return type view
use Illuminate\View\View; 
// import Facedes Storage
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    /** 
    * index
    *
    * @return void
    */
    public function index() : View {
        // get all data product
        $products = Product::latest()->paginate(10);
        $title = 'Data Product';

        // render view wit product
        return view('products.index', compact('products', 'title'));
    }

    /**
    * create
    *
    * @return view
    */
    public function create() : View {
        $title = 'Add New Product';
        return view('products.create', compact('title'));
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        //validate form
        $request->validate([
            'image'         => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'title'         => 'required|min:5',
            'description'   => 'required|min:10',
            'price'         => 'required|numeric',
            'stock'         => 'required|numeric'
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('products', $image->hashName());

        //create product
        Product::create([
            'image'         => $image->hashName(),
            'title'         => $request->title,
            'description'   => $request->description,
            'price'         => $request->price,
            'stock'         => $request->stock
        ]);

        //redirect to index
        return redirect()->route('products.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * show
     * 
     * @param mixed $id
     * @return View
     */

    public function show(string $id) : View {
        // get product by id
        $title = 'Detail Product';
        $product = Product::findOrFail($id);

        // render view with product
        return view('products.show', compact('product', 'title'));
    }

    public function edit(string $id) : View {
        $title = 'Edit Product';
        $product = Product::findOrFail($id);

        return view('products.edit', compact('title', 'product'));
    }

    /**
     * 
     * update
     * @param mixed $request
     * @param mixed $id
     * @return RedirectResponse
     */

    public function update(Request $request, $id) : RedirectResponse {
         // validate form
        $request->validate([
            'image'         => 'image|mimes:jpeg,jpg,png|max:2048',
            'title'         => 'required|min:5',
            'description'   => 'required|min:10',
            'price'         => 'required|numeric',
            'stock'         => 'required|numeric'
        ]);

        // get product by id
        $product = Product::findOrFail($id);

        // check if image is uploaded
        if ($request->hasFile('image')) {
            // delete old image
            Storage::delete('products/'.$product->image);

            // upload new image
            $image = $request->file('image');
            $image->storeAs('products', $image->hashName());

            // update product with new image
            $product->update([
                'image'         => $image->hashName(),
                'title'         => $request->title,
                'description'   => $request->description,
                'price'         => $request->price,
                'stock'         => $request->stock
            ]);

        } else {
            // update product without image
            $product->update([
                'image' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock
            ]);
        }

        // redirect to index
        return redirect()->route('products.index')->with(['success' => 'Data Berhasil Diupdate']);
    }
}
