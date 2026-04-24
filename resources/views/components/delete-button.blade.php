<form action="{{ $url }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded">
        Delete
    </button>
</form>