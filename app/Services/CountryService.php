<?php

namespace App\Services;

use App\Contracts\CountryRepositoryInterface;
use App\Contracts\CountryServiceInterface;
use App\Models\Country;

class CountryService implements CountryServiceInterface
{
    protected CountryRepositoryInterface $countryRepository;

    public function __construct(CountryRepositoryInterface $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function getCountryByIso2(string $iso2Code): ?Country
    {
        return $this->countryRepository->findByIso2($iso2Code);
    }
}