<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'countries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'iso_alpha_2',
        'iso_alpha_3',
        'dialing_code',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean', // Cast 'is_active' to a boolean type
    ];

    /**
     * Get a country by its ISO-2 code.
     *
     * @param string $iso2Code The 2-character ISO country code (e.g., 'US', 'CM').
     * @return static|null
     */
    public static function findByIso2(string $iso2Code): ?self
    {
        // Ensure the lookup is case-insensitive by converting to uppercase
        return static::where('iso_alpha_2', strtoupper($iso2Code))->first();
    }

    /**
     * Get the brands associated with the country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function brands(): HasMany
    {
        // A Country has many Brands.
        // 'country_code' is the foreign key on the 'brands' table.
        // 'iso_alpha_2' is the local key on the 'countries' table (this model).
        return $this->hasMany(Brand::class, 'country_code', 'iso_alpha_2');
    }
}