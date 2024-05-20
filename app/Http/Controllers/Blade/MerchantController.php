<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Merchant;

class MerchantController extends Controller
{

    public function index()
    {
        is_forbidden('merchants.index');
        $merchants = Merchant::all();
        return view('pages.merchant.index', compact('merchants'));
    }

    public function show($id){
        is_forbidden('merchants.show');
        $merchant = Merchant::find($id);
        return view('pages.merchant.show', compact('merchant'));
    }

    public function create(){
        is_forbidden('merchants.create');
        return view('pages.merchant.create');
    }

    public function store(Request $request){
        is_forbidden('merchants.create');
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
        ]);
        Merchant::create($request->all());

        message_set('Мерчант успешно добавлен!', 'success');
        return redirect()->route('merchants.index');
    }

    public function edit($id){
        is_forbidden('merchants.edit');
        $merchant = Merchant::find($id);
        return view('pages.merchant.edit', compact('merchant'));
    }

    public function update(Request $request, $id){
        is_forbidden('merchants.edit');
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
        ]);
        $merchant = Merchant::find($id);
        $merchant->update($request->all());

        message_set('Торговец успешно обновлен!', 'success');
        return redirect()->route('merchants.index');
    }

    public function delete($id){
        is_forbidden('merchants.delete');
        $merchant = Merchant::find($id);
        $merchant->delete();
        message_set('Торговец успешно удален!', 'success');
        return redirect()->route('merchants.index');
    }

}
