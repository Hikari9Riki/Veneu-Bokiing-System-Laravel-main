<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $primaryKey = 'venueID';
    public $incrementing = false;
    protected $keyType = 'string';

    // ADD THIS LINE:
    public $timestamps = false; 

    protected $fillable = ['venueID', 'name', 'kuliyyah','location', 'capacity', 'available'];
}