<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Actor extends Model
{
    use HasFactory;
    public $fillable = ['name','country_id','birthday','description',];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
