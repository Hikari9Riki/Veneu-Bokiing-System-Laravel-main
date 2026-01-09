<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    // 1. Define Primary Key
    protected $primaryKey = 'venueID';

    // 2. IMPORTANT: Tell Laravel it is NOT a number
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'venueID',
        'name',
        'kuliyyah', // Ensure this is here
        'location',
        'capacity',
        'available'
    ];
}