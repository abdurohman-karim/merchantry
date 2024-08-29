<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $incomeSum = Transaction::where('type', 'in')->whereMonth('created_at', date('m'))->where('status', 'active')->sum('sum');
        $outcomeSum = Transaction::where('type', 'out')->whereMonth('created_at', date('m'))->where('status', 'active')->sum('sum');
        return view('home', compact('incomeSum', 'outcomeSum'));
    }
}
