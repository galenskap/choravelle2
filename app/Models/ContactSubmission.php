<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'page_id'
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
} 