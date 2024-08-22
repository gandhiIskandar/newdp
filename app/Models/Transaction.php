<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_id',
        'amount',
        'member_id',
        'bank_id', //bank digunakan untuk rekening member dengan tujuan deposit
        'member_account_id',
        'account_id',
        'new',
        'created_at',
        'website_id',
        'user_id',
    ];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function memberAccount()
    {
        return $this->belongsTo(MemberAccount::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
