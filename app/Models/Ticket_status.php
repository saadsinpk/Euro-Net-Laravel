<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket_status extends Model
{
    use HasFactory;

    protected $table = "ticket_status";

    protected $fillable = [
        'option',
        'updated_at',
        'created_at',
    ];

    
    public function tickets() {
        return $this->hasMany(Ticket::class, 'status');
    }
}
