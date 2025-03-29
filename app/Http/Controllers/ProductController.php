<?php

namespace App\Http\Controllers;
// import model product
use App\Models\Product;

// import return type view
use Illuminate\View\View; 


class ProductController extends Controller
{
    /* 
    * index
    *
    * @return void
    */
    public function index() : View {
        // get all data product
        $products = Product::latest()->paginate(10);

        // render view wit product
        return view('products.index', compact('products'));
    }
}
