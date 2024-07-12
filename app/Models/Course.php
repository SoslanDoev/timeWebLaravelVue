<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Course extends Model
{
    use HasFactory;
    public $table = 'course';
    public $timestamps = true;
    protected $fillable = [
        "name", "user_id", "html"
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
