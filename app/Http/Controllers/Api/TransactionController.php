<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DB::table(function ($query) {
            $query->select(
                'id',
                'date',
                'amount',
                'details',
                DB::raw("'expense' as type"),
                'expense_type as category',
                'image_path',
                'created_at',
                'payment_method_id'
            )
                ->from('costs')
                ->unionAll(
                    DB::table('incomes')
                        ->select(
                            'id',
                            'date',
                            'amount',
                            'details',
                            DB::raw("'income' as type"),
                            'income_type as category',
                            'image_path',
                            'created_at',
                            'payment_method_id'
                        )
                );
        }, 'transactions');

        // Apply date filter
        if ($request->has('month') && $request->has('year')) {
            $query->whereMonth('date', $request->month)
                ->whereYear('date', $request->year);
        }

        // Get transactions
        $transactions = $query->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return response()->json([
            'transactions' => $transactions
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
