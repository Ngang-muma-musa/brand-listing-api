<?php

namespace App\Contracts;

use App\Models\Country;

interface CountryRepositoryInterface
{
    public function findByIso2(string $iso2Code): ?Country;
}