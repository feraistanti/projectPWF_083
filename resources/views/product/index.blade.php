<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Header --}}
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 tracking-tight">Product List</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage your product inventory</p>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            @can('export-product')
                                <a href="#" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition duration-150 shadow-sm">
                                    Export Excel
                                </a>
                            @endcan

                            {{-- ✅ COMPONENT ADD --}}
                            <x-add-product :url="route('product.create')" :name="'Product'" />
                        </div>
                    </div>

                    {{-- Flash Message --}}
                    @if (session('success'))
                        <div class="mb-4 px-4 py-3 bg-green-500/10 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-300 rounded-lg text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Table --}}
                    <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th class="px-6 py-3">#</th>
                                    <th class="px-6 py-3">Name</th>
                                    <th class="px-6 py-3">Quantity</th>
                                    <th class="px-6 py-3">Price</th>
                                    <th class="px-6 py-3">Owner</th>
                                    <th class="px-6 py-3 text-right">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white dark:bg-gray-800 divide-y">
                                @forelse ($products as $product)
                                    <tr>
                                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4">{{ $product->name }}</td>
                                        <td class="px-6 py-4">{{ $product->quantity }}</td>
                                        <td class="px-6 py-4">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4">{{ $product->user->name ?? '-' }}</td>

                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end gap-2">

                                                {{-- View --}}
                                                <a href="{{ route('product.show', $product->id) }}">
                                                    View
                                                </a>

                                                {{-- ✅ COMPONENT EDIT --}}
                                                @can('update', $product)
                                                    <x-edit-button :url="route('product.edit', $product->id)" />
                                                @endcan

                                                {{-- ✅ COMPONENT DELETE --}}
                                                @can('delete', $product)
                                                    <x-delete-button :url="route('product.destroy', $product->id)" />
                                                @endcan

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-6">
                                            No products found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if ($products->hasPages())
                        <div class="mt-6">
                            {{ $products->links() }}
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>