<form id="switch-role-dropdown" action="{{ route('auth.switchRole') }}" method="POST" class="switch-role-dropdown hidden max-h-0 flex-1 flex-col overflow-y-hidden text-sm font-medium text-gray-600 shadow-inner-2 transition-all">
  @csrf
  @method('PATCH')
  @foreach (auth()->user()->roles as $role)
    <button type="submit" class="px-4 py-3 text-left hover:bg-gray-100" name="role-id" value="{{ $role->id }}">{{ $role->nama }}</button>
  @endforeach
</form>
