<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    use HasFactory;
    protected $table = 'customer';
    protected $primaryKey = 'customerID';
    protected $fillable = ['customerID', 'username', 'custName', 'password','gender','address','email','dateOfBirth'];
    public $timestamps = false;
}
