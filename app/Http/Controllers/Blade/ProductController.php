<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{

    public function index()
    {
        is_forbidden('products.index');
        $products = Product::deepFilters()->paginate(10);

        return view('pages.product.index', compact('products'));
    }

    public function create(){
        is_forbidden('products.create');
        return view('pages.product.create');
    }

    public function store(Request $request)
    {
        is_forbidden('products.create');
        $request->validate([
            'name' => 'required',
            'price' => 'required'
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->price = str_replace(',', '', $request->price);
        $product->surcharge = str_replace(',', '', $request->surcharge ?? '0');
        $product->sale_price = str_replace(',', '', $request->sale_price ?? '0');
        $product->count = '0';
        $product->save();

        message_set('Товар успешно добавлен', 'success');
        return redirect()->route('products.index');
    }

    public function edit($id){
        is_forbidden('products.edit');
        $product = Product::find($id);
        return view('pages.product.edit', compact('product'));
    }

    public function update(Request $request, $id){
        is_forbidden('products.edit');
        $request->validate([
            'name' => 'required',
            'price' => 'required',
        ]);

        $product = Product::find($id);

        $product->name = $request->name;
        $product->price = str_replace(',', '', $request->price);
        $product->surcharge = str_replace(',', '', $request->surcharge ?? '0');
        $product->sale_price = str_replace(',', '', $request->sale_price ?? '0');
        $product->count = str_replace(',', '', $request->count ?? '0');
        $product->save();

        message_set('Товар успешно обновлен', 'success');
        return redirect()->route('products.index');
    }

    public function delete($id){
        is_forbidden('products.delete');
        $product = Product::find($id);
        $product->delete();
        message_set('Товар успешно удален', 'success');
        return redirect()->route('products.index');
    }

    public function deleteAll(){
        is_forbidden('products.delete_all');
        Product::truncate();
        message_set('Товары успешно удалены', 'success');
        return redirect()->route('products.index');
    }

}
