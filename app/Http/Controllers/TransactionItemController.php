<?php

namespace App\Http\Controllers;

use App\Models\TransactionItem;
use Illuminate\Http\Request;

class TransactionItemController extends Controller
{
    public function index()
    {
        $transactionItems = TransactionItem::with('transaction','product')->paginate();
        return response()->json(['data' => $transactionItems]);
    }
}
