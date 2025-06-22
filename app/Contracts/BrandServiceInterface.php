<?php

namespace App\Contracts;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface BrandServiceInterface
{
    public function getAllBrands(): Collection;
    public function getBrandById(int $id): ?Brand;
    public function createBrand(array $data): Brand;
    public function updateBrand(int $id, array $data): ?Brand;
    public function deleteBrand(int $id): bool;
    public function getPaginatedBrands(int $perPage = 15): LengthAwarePaginator;

    /**
     *
     * @param string|null $cfIpCountryHeaderValue The value from the CF-IPCountry HTTP header.
     * @param int $limit The maximum number of brands to return.
     * @return Collection
     */
    public function getGeolocationToplist(?string $cfIpCountryHeaderValue = null, int $limit = 10): Collection;
}