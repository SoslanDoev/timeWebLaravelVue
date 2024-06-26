<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    use HasFactory;
    public $table = 'disciplines';
    public $timestamps = true;
    protected $fillable = [
        "name",
    ];
    
    public function tests()
    {
        return $this->hasMany(Test::class);
    }
}
