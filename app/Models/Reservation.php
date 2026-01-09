<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
protected $primaryKey = 'reservationID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'reservationID', // Essential for string primary keys
        'startDate', 
        'endDate',
        'startTime', 
        'endTime', 
        'status', 
        'venueID', 
        'user_id',       // Changed from 'id' to 'user_id'
        'reason'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function venue() {
        return $this->belongsTo(Venue::class, 'venueID', 'venueID');
    }
}