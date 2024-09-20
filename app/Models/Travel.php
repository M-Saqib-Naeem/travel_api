<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Travel extends Model
{
    use HasFactory, HasSlug, HasUuids;
    protected $table = "travels";

    protected $fillable = [
        'is_public',
        'name',
        'slug',
        'description',
        'number_of_days'
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function numberOfNights(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => $attributes['number_of_days'] - 1
        );
    }

    public function tours()
    {
        return $this->hasMany(Tour::class);
    }
}
