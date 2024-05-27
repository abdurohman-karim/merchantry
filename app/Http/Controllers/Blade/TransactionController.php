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

    public function income()
    {
        $products = Product::all();
        return view('pages.transaction.income', compact('products'));
    }

    public function incomeStore(Request $request)
    {


        try {
            DB::beginTransaction();

            // Extract data from the request
            $productIds = $request->input('product_id');
            $counts = $request->input('count');
            $prices = $request->input('price');

            // Loop through each product entry
            foreach ($productIds as $key => $productId) {
                // Retrieve the product from the database
                $product = Product::findOrFail($productId);

                // Calculate the sum for this transaction
                $sum = (float)$counts[$key] * (float)$prices[$key];

                // Create a new transaction entry
                Transaction::create([
                    'product_id' => $productId,
                    'count' => $counts[$key],
                    'type' => 'in', // Assuming all transactions in this method are incoming
                    'date' => now(), // Using Laravel's built-in helper for current timestamp
                    'sum' => $sum,
                    'price' => (int)str_replace(',', '', $prices[$key]),
                ]);

                // Update the product count
                $product->count += (int)$counts[$key];
                $product->save();
            }

            DB::commit();

            // Optionally, you can redirect the user after processing the form
            return redirect()->route('transactions.index')->with('success', 'Income created successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            // Handle any exceptions or errors
            return redirect()->back()->with('error', 'Error occurred while processing the income: ' . $e->getMessage());
        }
    }



    public function outcome()
    {
        return view('pages.transaction.outcome');
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
