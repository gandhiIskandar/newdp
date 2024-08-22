<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenditure extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'detail',
        'account_id',
        'currency_id',
        'website_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
