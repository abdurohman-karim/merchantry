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

        dd($request->all());

        $product_price = str_replace(',', '', $request->price);

        $product = Product::find($request->product_id);

        if ($request->type == 'in') {

            $product_count = (int)$product->count + (int)$request->count;
            $product->count = (string)$product_count;

            $sum_count = (int)$request->count * (int)$product_price;

            Transaction::create([
                'product_id' => $request->product_id,
                'count' => $request->count,
                'type' => $request->type,
                'date' => date('Y-m-d'),
                'sum' => (string)$sum_count,
                'price' => $product_price,
            ]);
            $product->save();

            return redirect()->route('transactions.index');
        }


        if ($request->type == 'out') {
            $product_count = (int)$product->count - (int)$request->count;
            $product->count = (string)$product_count;

            Transaction::create([
                'product_id' => $request->product_id,
                'count' => $request->count,
                'type' => $request->type,
                'sum_count' => $request->count * $product->price,
                'date' => date('Y-m-d'),
                'sum' => $request->count * $product->price,
                'price' => $product_price,
                'merchant_id' => 'unired'
            ]);
            $product->save();

            return redirect()->route('transactions.index');
        }

        return redirect()->route('transactions.index');
    }

}
