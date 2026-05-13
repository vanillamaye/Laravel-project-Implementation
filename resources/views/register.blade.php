@extends('app')

@section('main-content')
<div class="flex items-center justify-center py-10">
    <div class="bg-white p-8 rounded-lg shadow-md w-96 border-t-4 border-blue-500">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800 uppercase tracking-widest">Add New Staff</h2>
        
        <form action="{{ url('/register') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="text-[10px] font-bold text-gray-500 uppercase">Full Name</label>
                <input type="text" name="name" class="w-full p-2 border rounded focus:border-blue-500 outline-none" required>
            </div>
            <div class="mb-4">
                <label class="text-[10px] font-bold text-gray-500 uppercase">Email Address</label>
                <input type="email" name="email" class="w-full p-2 border rounded focus:border-blue-500 outline-none" required>
            </div>
            <div class="mb-4">
                <label class="text-[10px] font-bold text-gray-500 uppercase">Password</label>
                <input type="password" name="password" class="w-full p-2 border rounded focus:border-blue-500 outline-none" required>
            </div>
            <div class="mb-4">
                <label class="text-[10px] font-bold text-gray-500 uppercase">Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full p-2 border rounded focus:border-blue-500 outline-none" required>
            </div>
            <div class="mb-6">
                <label class="text-[10px] font-bold text-gray-500 uppercase">System Role</label>
                <select name="role" class="w-full p-2 border rounded font-bold text-blue-600">
                    <option value="user">STAFF (View Only)</option>
                </select>
            </div>
            <button class="w-full bg-blue-600 text-white font-bold py-2 rounded shadow-lg hover:bg-blue-700 transition">CREATE ACCOUNT</button>
            
            <div class="mt-4 text-center">
                <a href="{{ url('/shop') }}" class="text-[10px] font-bold text-gray-400 hover:text-gray-600 uppercase">Cancel and Go Back</a>
            </div>
        </form>
    </div>
</div>
@endsection