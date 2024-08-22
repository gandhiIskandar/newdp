<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivilegeType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function privileges()
    {
        return $this->hasMany(Privilege::class);

    }
}
