<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    use HasFactory;

    protected $fillable = ['privilege_name'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_privileges');
    }

    public function privilege_type()
    {
        return $this->belongsTo(PrivilegeType::class);
    }
}
