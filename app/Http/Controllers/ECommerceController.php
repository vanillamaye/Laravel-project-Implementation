<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;


class ECommerceController extends Controller
{
    public function index() {
        $items = Product::all();
        return view('test', compact('items'));
    }

    public function update(Request $request, $id) 
{
    $product = Product::findOrFail($id);
    
    $product->qty = $request->amount;
    $product->supplier = $request->supplier;
    $product->price = $request->price;
    $product->purchase_date = $request->purchase_date;
    
    $product->save();

    return redirect()->back()->with('success', 'Updated details for ' . $product->name . '!');
}
    public function store(Request $request)
{
    
    $request->validate([
        'name' => 'required',
        'stocks' => 'required|integer',
        'product_number' => 'nullable', 
        'supplier' => 'nullable',       
        'purchase_date' => 'nullable|date',
        'price' => 'nullable|numeric',
    ]);

    Product::create($request->all());

    return redirect()->back()->with('success', 'Product added successfully!');
}

    public function destroy($id) {
        if (Auth::user()->role !== 'admin') return redirect()->back();
        Product::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Product removed.');
    }

    public function generatePDF() //generate ng pdf na to
    {
        $products = Product::all();

        //kinuha ang toal lahat ng items
        $totalInventoryValue = $products->sum(function($product) {
            return $product->stocks * $product->price;
        });

        $pdf = Pdf::loadView('pdf.inventory_report', compact ('products', 'totalInventoryValue'));

        return $pdf->download('inventory-Report.pdf');
    }
}