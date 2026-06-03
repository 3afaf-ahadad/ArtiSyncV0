<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = ['machine_id', 'date', 'description'];

    protected $casts = ['date' => 'date'];

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }
}