<?php

namespace App\Http\Controllers;
// import model product
use App\Models\Product;
// import return type redirectResponse
use Illuminate\Http\RedirectResponse;
// import Http Request
use Illuminate\Http\Request;

// import return type view
use Illuminate\View\View; 


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
}
