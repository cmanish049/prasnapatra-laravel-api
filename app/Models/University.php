<?php

namespace App\Models;

use Override;
use Database\Factories\UniversityFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    /** @use HasFactory<UniversityFactory> */
    use HasFactory;

    #[Override]
    protected $guarded = [];
}
