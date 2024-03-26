<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Transaction extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transaction_no',
        'transaction_date',
        'company_id',
        'outlet_id',
        'term',
        'date_delivered',
        'product_id',
        'quantity',
        'on_hand',
        'sold',
        'unit_price',
        'total'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
