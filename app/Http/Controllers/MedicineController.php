<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicineUpdateRequest;
use App\Services\MedicineFilterService;
use App\Models\Medicine;
use App\Traits\ApiResponseTrait;
use App\Middleware\LocaleMiddleware;
use App\Http\Requests\StoreMedicineRequest;
use App\Http\Requests\ShowMedicineRequest;
use Illuminate\Http\Request;
use Exception;

class MedicineController extends Controller
{
    use ApiResponseTrait;

    // Get medicines
    public function index(Request $request)
    {
        // Pagination
        $perPage = $request->input('per_page', 7);

        // Query the medicines
        $medicines = Medicine::with(['orders']);

        // Filtering based on minimum and maximum price
        if ($request->has('price_min') && $request->has('price_max')) {
            $minPrice = $request->input('price_min');
            $maxPrice = $request->input('price_max');
            $medicines->whereBetween('price', [$minPrice, $maxPrice]);
        }
        // Searching 
        if ($request->has('search')) {
            $search = $request->input('search');
            
            $medicines->where(function ($query) use ($search) {
                $query->where('name', '=', $search)  // Exact match for medicine name
                    ->orWhereHas('orders', function ($query) use ($search) {
                        $query->where('customer_name', '=', $search);  // Exact match for customer_name in orders
                    });
            });
        }
        // Sorting
        if ($request->has('sort_by') && $request->has('sort_order')) {
            $sortBy = $request->input('sort_by');
            $sortOrder = $request->input('sort_order');

            $medicines->orderBy($sortBy, $sortOrder);
        } else {
            //Set id as default 
            $medicines->orderBy('id', 'asc');
        }

        if ($request->has('page')) {
            $medicines = $medicines->paginate($perPage)->items();
        } else {
            $medicines = $medicines->get();
        }
        return response()->json([
            'data' => $medicines,
            'message' => __('messages.medicines.fetched'),
            'status' => '1'
        ]);
    }
    
    // Create a medicine
    public function store(StoreMedicineRequest $request)
    {
        $medicine = Medicine::create(
            [
                'name' => $request->name,
                'description' => $request->description,
                'stock' => $request->stock,
                'price' => $request->price
            ]
        );
        
        return response()->json([
            'data' => $medicine,
            'message' => __('messages.medicines.created')
        ]);
    }

    // Show single medicine
    public function show(Medicine $medicine)
    {
        return response()->json([
            'data' => $medicine,
            'message' => __('messages.medicines.found')
        ]);
    }

    // Update medicine
    public function update(MedicineUpdateRequest $request, Medicine $medicine)
    {
        if ($request->name) {
            $medicine->name = $request->name;
        }

        if ($request->has('description')) {
            $medicine->description = $request->input('description');
        }

        if ($request->has('stock')) {
            $medicine->stock = $request->input('stock');
        }

        if ($request->has('price')) {
            $medicine->price = $request->input('price');
        }

        // Save the updated medicine
        $medicine->save();

        return response()->json([
            'data' => $medicine,
            'message' => __('messages.medicines.updated')
        ]);
    }

    // Delete medicine
    public function destroy(Medicine $medicine)
    {
        $medicine->delete();
        return response()->json([
            'data' => $medicine,
            'message' => __('messages.medicines.deleted')
        ]);
    }
}