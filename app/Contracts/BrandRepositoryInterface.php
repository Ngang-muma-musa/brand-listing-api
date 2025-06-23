<?php

namespace App\Contracts;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface BrandRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?Brand;
    public function create(array $data): Brand;
    public function update(int $id, array $data): ?Brand;
    public function delete(int $id): bool;
    public function getTopList(?string $countryCode = null, int $limit = 10): Collection;
    public function getPaginated(int $perPage = 15): LengthAwarePaginator;
}