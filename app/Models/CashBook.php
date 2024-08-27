<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_id',
        'amount',
        'detail',
        'user_id',
        'website_id',
        'balance', //pendapatan - pengeluaran
        'note' 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
