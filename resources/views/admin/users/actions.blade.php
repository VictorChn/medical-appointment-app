<div class="flex items-center gap-2">
    <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center px-2 py-1 text-xs font-medium rounded bg-blue-600 hover:bg-blue-700 text-white">
        <i class="fa-solid fa-pen-to-square"></i>
    </a>

    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="delete-form">
        @csrf
        @method('DELETE')
        <x-wire-button type="submit" red xs>
            <i class="fa-solid fa-trash"></i>
        </x-wire-button>
    </form>
</div>