<?php

namespace App\Http\Controllers;

use App\Contracts\BrandServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Exceptions\CustomException;

class BrandController extends Controller
{
    protected BrandServiceInterface $brandService;

    public function __construct(BrandServiceInterface $brandService)
    {
        $this->brandService = $brandService;
    }

    public function index(): JsonResponse
    {
        try{
            $brands = $this->brandService->getPaginatedBrands(15);
            return response()->json($brands);
        } catch (\Exception $e) {
            throw new CustomException($e, 'Failed to get items', 500); 
        }
        
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'brand_name' => 'required|string|max:255',
                'brand_image' => 'required|url|max:255',
                'country_code' => 'required|string|size:2|exists:countries,iso_alpha_2',
                'rating' => 'required|integer|min:0|max:5',
            ]);

            $brand = $this->brandService->createBrand($validatedData);

            return response()->json($brand,201);
        } catch (\Exception $e) {
            throw new CustomException($e, $e->getMessage(), 400);
        }
    }

    public function show(int $id): JsonResponse
    {
        $brand = $this->brandService->getBrandById($id);

        if (!$brand) {
            return response()->json(['message' => 'Brand not found'], 404);
        }

        return response()->json($brand,200);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'brand_name' => 'string|max:255',
                'brand_image' => 'url|max:255',
                'country_code' => 'string|size:2|exists:countries,iso_alpha_2',
                'rating' => 'integer|min:0|max:5',
            ]);

            $brand = $this->brandService->updateBrand($id, $validatedData);

            if (!$brand) {
                return response()->json(['message' => 'Brand not found'], 404);
            }

            return response()->json(204);
        } catch (\Exception $e) {
            throw new CustomException($e, $e->getMessage(), 400);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->brandService->deleteBrand($id);

        if (!$deleted) {
            return response()->json(['message' => 'Brand not found or could not be deleted'], 404);
        }

        return response()->json(null, 204);
    }

    public function topList(Request $request): JsonResponse
    {
        $countryCodeHeader = $request->header('CF-IPCountry');
        $limit = $request->input('limit', 10);
        if (!is_numeric($limit) || $limit < 1 || $limit > 100) {
            return response()->json(['message' => 'Invalid limit parameter. Must be between 1 and 100.'], 400);
        }
        $topBrands = $this->brandService->getGeolocationToplist($countryCodeHeader, $limit);

        return response()->json($topBrands);
    }
}