@extends('app')

@section('main-content')
<div class="bg-white p-6 rounded-lg shadow-lg" x-data="{ openModal: false, activeId: null, productName: '' }">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 text-center uppercase tracking-widest text-blue-600">Inventory Management</h1>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded-md mb-6 shadow-md text-center font-bold">{{ session('success') }}</div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse border border-gray-200">
            <thead class="bg-gray-100">
                <tr class="text-gray-600 uppercase text-xs font-bold">
                    <th class="px-6 py-4 border-b text-center">Product Name</th>
                    <th class="px-6 py-4 border-b text-center">Status</th>
                    <th class="px-6 py-4 border-b text-center text-blue-600">Current Stocks</th>
                    <th class="px-6 py-4 border-b text-center">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 divide-y divide-gray-100">
                @foreach($items as $product)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-center font-medium">{{ $product->name }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($product->qty > 0)
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold uppercase">● Available</span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold uppercase">● Out of Stock</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center font-bold text-3xl text-blue-600">{{ $product->qty }}</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex flex-col items-center space-y-2">
                           
                            @if(Auth::user()->role == 'admin')
                                <button @click="openModal = true; activeId = {{ $product->id }}; productName = '{{ $product->name }}'" 
                                        class="bg-blue-600 text-white px-6 py-2 rounded-md text-xs font-bold hover:bg-blue-700 shadow-md transition w-32 uppercase">
                                    Update
                                </button>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Sigurado ka ba?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-[10px] font-bold uppercase hover:underline">Remove</button>
                                </form>
                            @else
                                <span class="text-gray-400 italic text-xs font-bold uppercase tracking-tighter">View Only Access</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-cloak>
        <div class="bg-white rounded-lg shadow-2xl w-96 p-6 transform transition-all" @click.away="openModal = false">
            <h2 class="text-xl font-bold mb-4 border-b pb-2 text-gray-800">Update <span x-text="productName" class="text-blue-600"></span></h2>

            <form :action="'{{ url('/update-qty') }}/' + activeId" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-6">
                    <label class="block text-sm font-bold mb-2 text-gray-700 text-left uppercase tracking-tighter">Enter New Quantity:</label>
                    <input type="number" name="amount" min="0" placeholder="0" required
                           class="w-full border-2 border-gray-300 rounded-md p-2 focus:border-blue-500 outline-none font-bold text-center text-xl">
                </div>

                <div class="flex justify-end space-x-3 border-t pt-4">
                    <button type="button" @click="openModal = false" class="px-4 py-2 text-gray-500 font-bold uppercase text-xs hover:text-gray-800">Cancel</button>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md font-bold hover:bg-blue-700 text-xs shadow-lg uppercase active:scale-95 transition">Confirm Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<style> [x-cloak] { display: none !important; } </style>
@endsection