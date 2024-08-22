<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = ['website_id', 'account_id', 'amount', 'tt_atas', 'account_tt_id'];

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function accountTransfer()
    {
        return $this->belongsTo(Account::class, 'account_tt_id');
    }
}
