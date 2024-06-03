<?php

namespace App\Models;

use App\Http\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    use Searchable;
    protected $fillable = [
        'name',
        'price',
        'count',
        'sale_price',
        'surcharge'
    ];

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
}
