<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $primaryKey = 'reservationID';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['reservationID', 'date', 'startTime', 'endTime', 'status', 'venueID', 'id', 'reason'];

    // Relationship: A reservation belongs to one User
    public function user() {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    // Relationship: A reservation belongs to one Venue
    public function venue() {
        return $this->belongsTo(Venue::class, 'venueID', 'venueID');
    }
}
