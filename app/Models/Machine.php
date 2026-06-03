<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'filiere_id', 'status'];

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class)->orderBy('date', 'desc');
    }
}