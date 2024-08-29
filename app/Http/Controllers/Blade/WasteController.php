<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Waste;
use App\Models\Product;

class WasteController extends Controller
{
    public function index()
    {
        is_forbidden('waste.index');
        $wastes = Waste::deepFilters()->paginate(10);
        return view('pages.waste.index', compact('wastes'));
    }

    public function create()
    {
        is_forbidden('waste.create');
        $products = Product::all();
        return view('pages.waste.create', compact('products'));
    }

    public function store(Request $request){
        is_forbidden('waste.create');
        $this->validate($request, [
            'product_id' => 'required|max:255',
            'count' => 'required|max:255',
        ]);

        $product = Product::findOrFail($request->product_id);
        $count = str_replace(',', '', $request->count);
        $lost_amount = $product->price * $count;

        if($product->count < $count){
            message_set('Недостаточно запасов', 'error');
            return redirect()->route('waste.create')->withInput();
        }
        $product->update([
            'count' => $product->count - $count
        ]);

        Waste::create([
            'name' => $product->name ?? 'N/A',
            'product_id' => $request->product_id,
            'count' => $count,
            'price' => $product->price ?? 'N/A',
            'lost_amount' => $lost_amount ?? 'N/A',
        ]);

        message_set('Отходы успешно добавлены', 'success');
        return redirect()->route('waste.index');
    }


    public function delete($id)
    {
        is_forbidden('waste.delete');
        $waste = Waste::findOrFail($id);
        $product = Product::findOrFail($waste->product_id);

        $product->count = (string)((int)$product->count + (int)$waste->count);
        $product->save();

        $waste->delete();
        message_set('Отход успешно удален', 'success');
        return redirect()->route('waste.index');
    }

}
