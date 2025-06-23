<?php

namespace App\Repositories\Eloquent;

use App\Contracts\BrandRepositoryInterface;
use App\Contracts\CountryRepositoryInterface;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class BrandRepository implements BrandRepositoryInterface
{
    protected Brand $model;
    protected CountryRepositoryInterface $countryRepository;

    /**
     *
     * @param Brand $model
     * @param CountryRepositoryInterface $countryRepository
     */
    public function __construct(Brand $model, CountryRepositoryInterface $countryRepository)
    {
        $this->model = $model;
        $this->countryRepository = $countryRepository; 
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find(int $id): ?Brand
    {
        return $this->model->find($id);
    }

    public function create(array $data): Brand
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): ?Brand
    {
        $brand = $this->model->find($id);
        if ($brand) {
            $brand->update($data);
            return $brand;
        }
        return null;
    }

    public function delete(int $id): bool
    {
        $brand = $this->model->find($id);
        if ($brand) {
            return $brand->delete();
        }
        return false;
    }

    /**
     * Get a toplist of brands based on country code or default (global).
     *
     * @param string|null $countryCode The 2-char ISO country code.
     * @param int $limit The maximum number of brands to return.
     * @return Collection
     */
    public function getTopList(?string $countryCode = null, int $limit = 10): Collection
    {
        $query = $this->model->query();

        if ($countryCode) {
            // Check if a country with this ISO-2 code exists in our database
            $country = $this->countryRepository->findByIso2($countryCode); 

            if ($country) {
                $query->where('country_code', $country->iso_alpha_2);
                Log::info("Fetching toplist for country: " . $country->name);
            } else {
                // If country code is provided but not found in our DB, fall back to default
                Log::warning("Country code '$countryCode' not found in database for toplist. Falling back to global default.");
            }
        } else {
            Log::info("Fetching default global toplist (no country code provided).");
        }

        return $query->orderByDesc('rating')
                     ->limit($limit)
                     ->get();
    }

    public function getPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }
}