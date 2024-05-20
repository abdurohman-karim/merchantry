<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

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
        $product_count = str_replace(',', '', $request->count);
        $product = Product::find($request->product_id);



        try {
            DB::beginTransaction();
            if ($request->type == 'in') {
                $product->count = (string)((int)$product->count + (int)$product_count);
                $sum_count = (int)$product_count * (int)$product_price ?? (int)$product->price;
            } elseif ($request->type == 'out') {
                if ($product->count < $request->count) {
                    message_set('Недостаточно единиц продукта', 'error');
                    return redirect()->route('transactions.create');
                }


                $product->count = (string)((int)$product->count - (int)$request->count);
                $sum_count = (int)$product_count * (int)$product_price;
            }

            Transaction::create([
                'product_id' => $request->product_id,
                'count' => str_replace(',', '', $request->count),
                'type' => $request->type,
                'date' => date('Y-m-d'),
                'sum' => (string)$sum_count,
                'price' => $product_price,
                'merchant_id' => $request->merchant_id ?? null, // Add null coalescing for merchant_id
            ]);

            $product->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            message_set('Произошла ошибка', 'error');
            return redirect()->back();
        }

        message_set('Транзакция успешно добавлена', 'success');
        return redirect()->route('transactions.index');
    }
}
