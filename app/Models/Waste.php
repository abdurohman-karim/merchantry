<?php

namespace App\Models;

use App\Http\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waste extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name',
        'description',
        'count',
        'product_id',
        'price',
        'lost_amount'
    ];
}
