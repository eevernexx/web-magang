<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'status',
        'is_valid',
        'report_date',
        'user_id'
    ];

    protected $casts = [
        'report_date' => 'datetime',
        'is_valid' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(SubmissionImage::class);
    }
}
