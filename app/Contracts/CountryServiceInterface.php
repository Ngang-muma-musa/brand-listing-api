<?php

namespace App\Contracts;

use App\Models\Country;

interface CountryServiceInterface
{
    public function getCountryByIso2(string $iso2Code): ?Country;
}