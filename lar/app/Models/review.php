<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class review extends Model
{
    use HasFactory;
    protected $table = 'reviews';
    protected $primaryKey = 'reviewID';
    protected $fillable = ['reviewID','customerID', 'showID', 'adminID', 'comment','rating','banned','flagged','date_posted'];
    public $timestamps = false;
}
