<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $casts = [ 'show_public' => 'boolean' ];

    protected $table = 'registration';

    protected $fillable = [
        'name',
        'email',
        'title',
        'rsvp',
        'agenda',
        'meeting_id',
        'show_public'
    ];

}
