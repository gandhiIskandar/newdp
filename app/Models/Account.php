<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = ['balance', 'website_id', 'number', 'under_name', 'bank_id'];

    public function expenditures()
    {
        return $this->hasMany(Expenditure::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}
