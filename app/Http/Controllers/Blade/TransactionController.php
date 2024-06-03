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
        is_forbidden('transactions.index');
        $transactions = Transaction::deepFilters()
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'desc')
            ->get();

        return view('pages.transaction.index', compact('transactions'));
    }

    public function showByDate($date)
    {
        is_forbidden('transactions.index');
        $transactions = Transaction::whereDate('created_at', $date)->get();

        $totalIncomePrice = $transactions->where('type', 'in')->sum('sum');
        $totalOutcomePrice = $transactions->where('type', 'out')->sum('sum');
        $totalIncomeCount = $transactions->where('type', 'in')->sum('count');
        $totalOutcomeCount = $transactions->where('type', 'out')->sum('count');

        return view('pages.transaction.show_by_date', compact(
            'transactions', 'date', 'totalIncomePrice', 'totalOutcomePrice', 'totalIncomeCount', 'totalOutcomeCount'
        ));
    }

    public function income()
    {
        is_forbidden('transactions.income');
        $products = Product::all();
        return view('pages.transaction.income', compact('products'));
    }

    public function incomeStore(Request $request)
    {
        is_forbidden('transactions.income');

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
                $sum = (int)$counts[$key] * (int)str_replace(',', '', $prices[$key]);

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
                $product->price = (int)str_replace(',', '', $prices[$key]);
                $product->sale_price = (int)str_replace(',', '', $prices[$key]) * ((int)$product->surcharge / 100) + (int)str_replace(',', '', $prices[$key]);
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
        is_forbidden('transactions.outcome');
        $products = Product::all();
        $merchants = Merchant::all();
        return view('pages.transaction.outcome', compact('products', 'merchants'));
    }


    public function outcomeStore(Request $request)
    {
        is_forbidden('transactions.outcome');
        try {
            DB::beginTransaction();

            // Extract data from the request
            $productIds = $request->input('product_id');
            $counts = $request->input('count');
            $prices = $request->input('price');
            $merchantId = $request->input('merchant_id'); // Make sure you use merchant_id not merchants

            // Loop through each product entry
            foreach ($productIds as $key => $productId) {
                // Retrieve the product from the database
                $product = Product::findOrFail($productId);

                if ($product->count < $counts[$key]) {
                    message_set('Недостаточно единиц продукта', 'error');
                    return redirect()->back();
                }

                // Calculate the sum for this transaction
                $sum = (int)$counts[$key] * (int)str_replace(',', '', $prices[$key]);

                // Create a new transaction entry
                Transaction::create([
                    'product_id' => $productId,
                    'count' => $counts[$key],
                    'type' => 'out', // Assuming all transactions in this method are outgoing
                    'date' => now(), // Using Laravel's built-in helper for current timestamp
                    'sum' => $sum,
                    'price' => (int)str_replace(',', '', $prices[$key]),
                    'merchant_id' => $merchantId, // Use merchant_id from the request
                ]);

                // Update the product count
                $product->count -= (int)$counts[$key];
                $product->save();
            }

            DB::commit();

            // Optionally, you can redirect the user after processing the form
            message_set('Транзакции добавлены', 'success');
            return redirect()->route('transactions.index');
        } catch (\Exception $e) {
            DB::rollBack();

            // Handle any exceptions or errors
            message_set('Ошибка: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }


    public function deleteAll(){
        is_forbidden('transactions.delete_all');
        Transaction::truncate();

        message_set('Транзакции удалены', 'success');
        return redirect()->route('transactions.index');
    }

    public function create(){
        is_forbidden('transactions.create');
        $products = Product::all();
        $merchants = Merchant::all();
        return view('pages.transaction.create', compact('products', 'merchants'));
    }

    public function store(Request $request)
    {
        is_forbidden('transactions.create');
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
