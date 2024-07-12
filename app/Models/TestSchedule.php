<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestSchedule extends Model
{
    use HasFactory;
    public $table = 'test_schedules';
    public $timestamps = true;
    protected $fillable = [
        "test_id",
        "start_time",
        "end_time",
    ];
    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}