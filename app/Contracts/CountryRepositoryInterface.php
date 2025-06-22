<?php

namespace App\Contracts;

use App\Models\Country;
use Illuminate\Database\Eloquent\Collection;

interface CountryRepositoryInterface
{
    public function findByIso2(string $iso2Code): ?Country;
}