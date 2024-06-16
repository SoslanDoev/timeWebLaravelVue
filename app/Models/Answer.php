<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    public $table = 'answers';
    public $timestamps = true;
    protected $fillable = [
        "question_id",
        "text",
        "points",
    ];
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
