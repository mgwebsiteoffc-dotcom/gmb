@extends('layouts.admin')

@section('title', 'Edit User — Untab SaaS Admin')
@section('page_title', 'Edit User')

@section('content')
<form method="POST" action="{{ route('admin.users.update', $user) }}" class="max-w-2xl">
    @csrf @method('PUT')
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-5">
        <div class="flex items-center gap-4 pb-4 border-b border-slate-100">
            <div class="w-14 h-14 rounded-2xl bg-brand-100 text-brand-700 flex items-center justify-center font-black text-xl uppercase">{{ $user->name[0] }}</div>
            <div>
                <div class="font-black font-display text-slate-900">{{ $user->name }}</div>
                <div class="text-xs text-slate-400">Editing user #{{ $user->id }}</div>
            </div>
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Full Name</label>
            <input name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Email</label>
            <input name="email" type="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">New Password (leave blank to keep)</label>
                <input name="password" type="password" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Confirm Password</label>
                <input name="password_confirmation" type="password" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Role</label>
            <select name="role" id="roleSelect" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                <option value="user" @selected($user->role === 'user')>User / Staff</option>
                <option value="brand_admin" @selected($user->role === 'brand_admin')>Brand Admin</option>
                <option value="super_admin" @selected($user->role === 'super_admin')>Super Admin</option>
            </select>
        </div>
        <div id="clientField">
            <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Assign to Brand / Client</label>
            <select name="client_id" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                <option value="">— None —</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" @selected($user->client_id === $client->id)>{{ $client->name }}</option>
                @endforeach
            </select>
        </div>
        <label class="flex items-center gap-2.5 text-sm font-semibold text-slate-700">
            <input type="checkbox" name="is_active" value="1" @checked($user->is_active) class="rounded border-slate-300 text-brand-600 focus:ring-brand-500 h-4 w-4">
            Account active (can sign in)
        </label>
        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm px-5 py-2.5 rounded-xl transition-all shadow-md">Save Changes</button>
            <a href="{{ route('admin.users.index') }}" class="text-sm font-bold text-slate-500 hover:text-slate-700">Cancel</a>
        </div>
    </div>
</form>

@push('scripts')
<script>
    const roleSelect = document.getElementById('roleSelect');
    const clientField = document.getElementById('clientField');
    function toggleClient() {
        clientField.style.display = roleSelect.value === 'brand_admin' ? 'block' : 'none';
    }
    roleSelect.addEventListener('change', toggleClient);
    toggleClient();
</script>
@endpush
@endsection
