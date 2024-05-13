<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'pack',
        'count',
        'sum_pack',
        'sum_count',
        'sum',
        'merchant_id',
        'type',
        'date',
        'price'
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function merchant(){
        return $this->belongsTo(Merchant::class, 'merchant_id');
    }
}
