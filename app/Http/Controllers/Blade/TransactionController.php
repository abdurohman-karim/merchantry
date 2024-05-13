<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product;

class TransactionController extends Controller
{

    public function index()
    {

        $transactions = Transaction::orderBy('id', 'desc')->get();

        return view('pages.transaction.index', compact('transactions'));
    }

    public function create(){
        $products = Product::all();
        $merchants = Merchant::all();
        return view('pages.transaction.create', compact('products', 'merchants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'count' => 'required',
            'type' => 'required',
        ]);

        $product_price = str_replace(',', '', $request->price);

        $product = Product::find($request->product_id);

        if ($request->type == 'in') {
            $product->count = (string)((int)$product->count + (int)$request->count);
            $sum_count = (int)$request->count * (int)$product_price;
        } elseif ($request->type == 'out') {
            $product->count = (string)((int)$product->count - (int)$request->count);
            $sum_count = $request->count * $product->price;
        }

        Transaction::create([
            'product_id' => $request->product_id,
            'count' => $request->count,
            'type' => $request->type,
            'date' => date('Y-m-d'),
            'sum' => (string)$sum_count,
            'price' => $product_price,
            'merchant_id' => $request->merchant_id ?? null, // Add null coalescing for merchant_id
        ]);

        $product->save();

        return redirect()->route('transactions.index');
    }


}
