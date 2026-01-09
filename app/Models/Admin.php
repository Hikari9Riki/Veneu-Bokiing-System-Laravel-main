<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false; 

    // If you didn't add created_at/updated_at to these specific tables:
    public $timestamps = false;

    protected $fillable = ['id', 'matricNo']; // Change fields for Staff/Admin

    // This links the Student record back to the main User profile
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
}
