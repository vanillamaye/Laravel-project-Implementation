<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ECommerce extends Controller
{
    public function index() {
        $items = Product::all();
        return view('test', compact('items'));
    }

    public function update(Request $request, $id) {
        if (Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Admin access only!');
        }
        $request->validate(['amount' => 'required|numeric|min:0']);
        $product = Product::findOrFail($id);
        $product->qty = $request->amount;
        $product->save();
        return redirect()->back()->with('success', "Stock updated for {$product->name}!");
    }

    public function destroy($id) {
        if (Auth::user()->role !== 'admin') return redirect()->back();
        Product::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Product removed.');
    }
}