<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ElectronicFilingCategory extends Model
{
    protected $fillable = [

        'name',

        'description',

        'icon',

        'color',

    ];

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'filing_category_id');
    }
}