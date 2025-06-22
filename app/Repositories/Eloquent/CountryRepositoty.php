<?php

namespace App\Repositories\Eloquent;

use App\Contracts\CountryRepositoryInterface;
use App\Models\Country;
use Illuminate\Database\Eloquent\Collection;

class CountryRepository implements CountryRepositoryInterface
{
    protected Country $model;

    public function __construct(Country $model)
    {
        $this->model = $model;
    }

    public function findByIso2(string $iso2Code): ?Country
    {
        return $this->model->where('iso_alpha_2', strtoupper($iso2Code))->first();
    }
}