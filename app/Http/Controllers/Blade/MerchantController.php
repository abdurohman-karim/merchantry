<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Merchant;

class MerchantController extends Controller
{

    public function index()
    {
        $merchants = Merchant::all();
        return view('pages.merchant.index', compact('merchants'));
    }
}
