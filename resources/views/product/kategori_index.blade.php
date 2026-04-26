<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Header --}}
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold">Category List</h2>
                            <p class="text-sm text-gray-500">Manage your category</p>
                        </div>

                        <a href="{{ route('kategori.create') }}"
                           class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm">
                            + Add Category
                        </a>
                    </div>

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Table --}}
                    <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700">
                        <table class="min-w-full text-sm">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3">#</th>
                                    <th class="px-6 py-3">Name</th>
                                    <th class="px-6 py-3">Total Product</th>
                                    <th class="px-6 py-3 text-right">Action</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white dark:bg-gray-800 divide-y">
                                @forelse ($kategoris as $kategori)
                                    <tr>
                                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4">{{ $kategori->name }}</td>

                                        {{-- ✅ FIX COUNT --}}
                                        <td class="px-6 py-4">
                                            {{ $kategori->products_count ?? 0 }}
                                        </td>

                                        <td class="px-6 py-4 text-right space-x-2">

                                            {{-- EDIT --}}
                                            <a href="{{ route('kategori.edit', $kategori->id) }}"
                                               class="text-blue-500 hover:underline">
                                                Edit
                                            </a>

                                            {{-- DELETE --}}
                                            <form action="{{ route('kategori.destroy', $kategori->id) }}"
                                                  method="POST"
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return confirm('Yakin hapus?')"
                                                        class="text-red-500 hover:underline">
                                                    Delete
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-6">
                                            No category found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>