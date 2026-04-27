<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Header --}}
                    <div class="flex items-center gap-3 mb-6">
                        <a href="{{ route('product.index') }}">
                            <div class="p-1.5 rounded-md text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </div>
                        </a>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 tracking-tight">Add Product</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Fill in the details to add a new product</p>
                        </div>
                    </div>

                    {{-- Menampilkan Pesan Error Umum --}}
                    @if ($errors->any())
                        <div class="mb-6 p-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800 dark:text-red-200">There were errors with your submission</h3>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Form --}}
                    <form action="{{ route('product.store') }}" method="POST" class="space-y-6">
                        @csrf

                        {{-- Name --}}
                        <div>
                            <label for="name">
                                <span class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Product Name <span class="text-red-500">*</span>
                                </span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                placeholder="e.g. Wireless Headphones"
                                class="w-full px-4 py-2.5 rounded-lg border text-sm 
                                {{ $errors->has('name') ? 'border-red-400 bg-red-50 dark:bg-red-900/20' : 'border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700' }} 
                                text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 
                                focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                            @error('name')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Quantity & Price --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="quantity">
                                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Quantity <span class="text-red-500">*</span>
                                    </span>
                                </label>
                                <input type="number" id="quantity" name="quantity" value="{{ old('quantity') }}"
                                    placeholder="0" min="0"
                                    class="w-full px-4 py-2.5 rounded-lg border text-sm 
                                    {{ $errors->has('quantity') ? 'border-red-400 bg-red-50 dark:bg-red-900/20' : 'border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700' }} 
                                    text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                                @error('quantity')
                                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="price">
                                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Price (Rp) <span class="text-red-500">*</span>
                                    </span>
                                </label>
                                <input type="number" id="price" name="price" value="{{ old('price') }}"
                                    placeholder="0" min="0" step="0.01"
                                    class="w-full px-4 py-2.5 rounded-lg border text-sm 
                                    {{ $errors->has('price') ? 'border-red-400 bg-red-50 dark:bg-red-900/20' : 'border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700' }} 
                                    text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                                @error('price')
                                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Category --}}
                        <div>
                            <label for="category_id">
                                <span class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Category <span class="text-red-500">*</span>
                                </span>
                            </label>

                            {{-- Perhatikan: name="category_id" (huruf kecil) --}}
                            <select name="category_id" id="category_id"
                                class="w-full px-4 py-2.5 rounded-lg border text-sm 
                                {{ $errors->has('category_id') ? 'border-red-400 bg-red-50 dark:bg-red-900/20' : 'border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700' }} 
                                text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">

                                <option value="">-- Choose Category --</option>

                                {{-- Perhatikan: Menggunakan $categories (huruf kecil sesuai Controller) --}}
                                @foreach ($categories as $k)
                                    <option value="{{ $k->id }}" {{ old('category_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('category_id')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Khusus Admin: Pilih Owner (User) --}}
                        @if(auth()->user()->role === 'admin')
                        <div>
                            <label for="user_id">
                                <span class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Product Owner <span class="text-red-500">*</span>
                                </span>
                            </label>
                            <select name="user_id" id="user_id" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm">
                                @foreach(\App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        {{-- Actions --}}
                        <div class="flex items-center justify-end gap-3 pt-2">
                            <a href="{{ route('product.index') }}"
                                class="px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                Cancel
                            </a>

                            <button type="submit"
                                class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
                                Save Product
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>