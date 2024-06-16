<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;
    public $table = 'tests';
    public $timestamps = true;
    protected $fillable = [
        "title",
        "description",
        "duration",
        "discipline_id",
        "author_id",
    ];
    public function discipline()
    {
        return $this->belongsTo(Discipline::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function testSchedules()
    {
        return $this->hasMany(TestSchedule::class);
    }
}
