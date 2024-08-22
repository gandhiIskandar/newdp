<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'username',
        'total_wd',
        'total_depo',
        'website_id',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function memberAccounts() //account = rekening
    {

        return $this->hasMany(MemberAccount::class);

    }
}
