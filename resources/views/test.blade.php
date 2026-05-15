@extends('app')

@section('main-content')
<div class="bg-white p-8 rounded-xl shadow-2xl" x-data="{ openModal: false, activeId: null, productName: '', currentQty: 0, currentSupplier: '', currentPrice: '', currentDate: '' }">
    
    <div class="flex justify-between items-center mb-8 border-b-2 border-gray-100 pb-6">
        <div>
            <h1 class="text-3xl font-black text-gray-800 uppercase tracking-tighter">Inventory Management</h1>
            <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1">Customer Frontline Solutions</p>
        </div>
        <a href="{{ route('inventory.report') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-lg shadow-lg text-sm font-black uppercase tracking-wider transition-all active:scale-95 flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
            Export PDF Report
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-500 text-white p-4 rounded-lg shadow-lg mb-8 text-center font-bold">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-xl border border-gray-200 shadow-sm">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr class="text-xs font-black text-gray-500 uppercase tracking-widest">
                    <th class="px-8 py-5 text-left">Product Details</th>
                    <th class="px-8 py-5 text-center">Supplier</th>
                    <th class="px-8 py-5 text-center">Cost Price</th>
                    <th class="px-8 py-5 text-center">Date Purchased</th>
                    <th class="px-8 py-5 text-center text-blue-600">Current Stocks</th>
                    <th class="px-8 py-5 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @foreach($items as $product)
                <tr class="hover:bg-blue-50/50 transition-colors">
                    <td class="px-8 py-6">
                        <div class="text-base font-bold text-gray-900">{{ $product->name }}</div>
                        <div class="flex items-center mt-1">
                            <span class="w-2 h-2 rounded-full mr-2 {{ $product->qty > 0 ? 'bg-green-500' : 'bg-red-500' }}"></span>
                            <span class="text-[10px] uppercase font-black {{ $product->qty > 0 ? 'text-green-600' : 'text-red-500' }}">
                                {{ $product->qty > 0 ? 'Available' : 'Out of Stock' }}
                            </span>
                        </div>
                    </td>
                    
                    <td class="px-8 py-6 text-center text-sm font-semibold text-gray-500 italic">
                        {{ $product->supplier ?? '---' }}
                    </td>

                    <td class="px-8 py-6 text-center">
                        <span class="text-lg font-black text-emerald-600">&#8369;{{ number_format($product->price ?? 0, 2) }}</span>
                    </td>

                    <td class="px-8 py-6 text-center">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-tighter">
                            {{ $product->purchase_date ? \Carbon\Carbon::parse($product->purchase_date)->format('M d, Y') : 'No Date Set' }}
                        </span>
                    </td>

                    <td class="px-8 py-6 text-center">
                        <span class="text-4xl font-black text-blue-600 tabular-nums">{{ $product->qty }}</span>
                    </td>

                    <td class="px-8 py-6 text-center">
                        <div class="flex flex-col items-center space-y-3">
                            @if(Auth::user()->role == 'admin')
                                <button @click="openModal = true; activeId = {{ $product->id }}; productName = '{{ $product->name }}'; currentQty = '{{ $product->qty }}'; currentSupplier = '{{ $product->supplier }}'; currentPrice = '{{ $product->price }}'; currentDate = '{{ $product->purchase_date }}'" 
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-2.5 rounded-md text-xs font-black uppercase shadow-md transition-all active:scale-95 w-full max-w-[120px]">
                                    Update
                                </button>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Sigurado ka ba?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-[10px] font-black uppercase tracking-tighter hover:underline transition">
                                        Remove Item
                                    </button>
                                </form>
                            @else
                                <span class="bg-gray-100 text-gray-400 px-4 py-2 rounded text-[10px] font-black uppercase">Read Only</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60 backdrop-blur-sm p-4" x-cloak>
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-8 border border-gray-100" @click.away="openModal = false">
            <div class="flex justify-between items-center border-b pb-4 mb-6">
                <h2 class="text-xl font-black text-gray-800 uppercase tracking-tight">Update <span x-text="productName" class="text-blue-600"></span></h2>
                <button @click="openModal = false" class="text-gray-400 hover:text-gray-900 text-2xl">&times;</button>
            </div>

            <form :action="'{{ url('/update-qty') }}/' + activeId" method="POST">
    @csrf @method('PUT')
                
                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 text-left">New Stock Quantity:</label>
                        <input type="number" name="amount" x-model="currentQty" required
                               class="w-full border-2 border-gray-100 rounded-xl p-4 text-center text-4xl font-black text-blue-700 bg-blue-50 focus:border-blue-400 outline-none transition-all">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 text-left">Supplier:</label>
                            <input type="text" name="supplier" x-model="currentSupplier"
                                   class="w-full border-2 border-gray-50 rounded-lg p-3 text-sm font-bold focus:border-blue-400 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 text-left">Purchase Date:</label>
                            <input type="date" name="purchase_date" x-model="currentDate"
                                   class="w-full border-2 border-gray-50 rounded-lg p-3 text-sm font-bold focus:border-blue-400 outline-none transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 text-left">Cost Price (&#8369;):</label>
                        <div class="relative text-left">
                            <span class="absolute left-4 top-3.5 font-bold text-gray-400">&#8369;</span>
                            <input type="number" step="0.01" name="price" x-model="currentPrice"
                                   class="w-full border-2 border-gray-50 rounded-lg p-3 pl-10 text-sm font-bold focus:border-blue-400 outline-none font-mono transition-all">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 mt-10 pt-6 border-t border-gray-50">
                    <button type="button" @click="openModal = false" class="text-gray-400 text-xs font-black uppercase hover:text-gray-800 transition">Cancel</button>
                    <button type="submit" class="bg-blue-600 text-white px-10 py-3 rounded-xl font-black text-xs uppercase shadow-xl hover:bg-blue-700 active:scale-95 transition-all">
                        Confirm Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<style> 
    [x-cloak] { display: none !important; }
    body { background-color: #f8fafc; }
</style>
@endsection