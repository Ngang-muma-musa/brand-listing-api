<?php

namespace App\Services;

use App\Contracts\BrandRepositoryInterface;
use App\Contracts\BrandServiceInterface;
use App\Contracts\CountryServiceInterface;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BrandService implements BrandServiceInterface
{
    protected BrandRepositoryInterface $brandRepository;
    protected CountryServiceInterface $countryService;

    public function __construct(
        BrandRepositoryInterface $brandRepository,
        CountryServiceInterface $countryService
    ) {
        $this->brandRepository = $brandRepository;
        $this->countryService = $countryService;
    }

    public function getAllBrands(): Collection
    {
        return $this->brandRepository->all();
    }

    public function getBrandById(int $id): ?Brand
    {
        return $this->brandRepository->find($id);
    }

    public function createBrand(array $data): Brand
    {
        if (!isset($data['admin_id']) && Auth::check()) {
            $data['admin_id'] = Auth::id();
        } else if (!isset($data['admin_id'])) {
             Log::warning("No admin_id provided for brand creation and no user authenticated.");
        }

        return $this->brandRepository->create($data);
    }

    public function updateBrand(int $id, array $data): ?Brand
    {
        return $this->brandRepository->update($id, $data);
    }

    public function deleteBrand(int $id): bool
    {
        return $this->brandRepository->delete($id);
    }

    public function getPaginatedBrands(int $perPage = 15): LengthAwarePaginator
    {
        return $this->brandRepository->getPaginated($perPage);
    }

    /**
     * Get a toplist of brands based on a given country code from Cloudflare header.
     *
     * @param string|null $cfIpCountryHeaderValue The value from the CF-IPCountry HTTP header.
     * @param int $limit The maximum number of brands to return.
     * @return Collection
     */
    public function getGeolocationToplist(?string $cfIpCountryHeaderValue = null, int $limit = 10): Collection
    {
        $countryCode = null;

        if ($cfIpCountryHeaderValue) {
            $country = $this->countryService->getCountryByIso2($cfIpCountryHeaderValue);

            if ($country) {
                $countryCode = $country->iso_alpha_2;
                Log::info("Toplist requested for valid country code: " . $countryCode);
            } else {
                Log::warning("Invalid or unknown CF-IPCountry header value: '$cfIpCountryHeaderValue'. Using default toplist.");
            }
        } else {
            Log::info("No CF-IPCountry header found. Using default toplist.");
        }

        return $this->brandRepository->getTopList($countryCode, $limit);
    }
}