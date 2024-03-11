<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::latest()->paginate();
        return response()->json(['data' => $transactions]);
    }

    public function store(Request $request)
    {
    // Validate the request data
        $validator = Validator::make($request->all(), [
            'transaction_date' => 'required|date_format:Y-m-d',
            'total_amount' => 'required|numeric',
            'payment_method' => 'nullable|string',
            'items' => 'required|array',
            'items.*.id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.subtotal' => 'required|numeric',
        ]);

        // Check for validation failure
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            // Begin database transaction
            DB::beginTransaction();

            // Create transaction
            $transaction = Transaction::create([
                'transaction_date' => $request->input('transaction_date'),
                'total_amount' => $request->input('total_amount'),
                'payment_method' => $request->input('payment_method')
            ]);

            // Create transaction items and reduce stock
            foreach ($request->input('items') as $item) {
                $product = Product::find($item['id']);
                $stocks = ProductStock::where('id_product',$product->id)->first();
                if (!$product) {
                    throw new \Exception('Product not found.');
                }

                if ($stocks->units < $item['quantity']) {
                    throw new \Exception('Insufficient stock for product with ID ' . $product->id);
                }

                // Create transaction item
                $transactionItem = new TransactionItem([
                    'id_transaction' => $transaction->id,
                    'id_product' => $item['id'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Save transaction item
                $transactionItem->save();

                // Reduce stock
                $stocks->units -= $item['quantity'];
                $stocks->save();
                $product->save();
            }

            // Commit database transaction
            DB::commit();

            return response()->json(['success' => true], 201);
        } catch (\Exception $e) {
            // Rollback database transaction on error
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);
        return response()->json(['data' => $transaction]);
    }

    //sementara off

}
