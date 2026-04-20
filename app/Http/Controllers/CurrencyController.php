<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::all();
        return view('currencies.index', compact('currencies'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'exchange_rate' => 'required|numeric|min:0',
        ]);

        $currency = Currency::findOrFail($id);
        $currency->update([
            'exchange_rate' => $request->exchange_rate
        ]);

        return redirect()->back()->with('success', 'تم تحديث سعر الصرف لعملة ' . $currency->currency_name);
    }
}
