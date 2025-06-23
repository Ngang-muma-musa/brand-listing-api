<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Brand extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'brands';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'brand_name',
        'brand_image',
        'country_code', // ISO-2 code
        'rating',
        'admin_id',   
    ];

    /**
     * Get the country that owns the brand.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country(): BelongsTo
    {
        // A Brand belongs to a Country.
        // 'country_code' is the foreign key on the 'brands' table (this model).
        // 'iso_alpha_2' is the local key on the 'countries' table.
        return $this->belongsTo(Country::class, 'country_code', 'iso_alpha_2');
    }

    /**
     * Get the admin user that created/manages the brand.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin(): BelongsTo
    {
        // A Brand belongs to a User (admin).
        // 'admin_id' is the foreign key on the 'brands' table (this model).
        // 'id' is the local key on the 'users' table (User model).
        return $this->belongsTo(User::class, 'admin_id', 'id');
    }
}