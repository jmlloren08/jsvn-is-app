<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Warehouse extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'withdrawal_date',
        'product_id',
        'quantity_out',
        'quantity_return',
        'sold',
        'stocks'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
