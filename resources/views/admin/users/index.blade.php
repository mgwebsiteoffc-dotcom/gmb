@extends('layouts.admin')

@section('title', 'Users & Roles — Untab SaaS Admin')
@section('page_title', 'Users & Roles')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <form method="GET" class="flex flex-wrap items-center gap-2">
            <input type="text" name="q" value="{{ $search }}" placeholder="Search name or email…"
                   class="w-64 rounded-xl border border-slate-300 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
            <select name="role" class="rounded-xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                <option value="">All Roles</option>
                <option value="super_admin" @selected($role === 'super_admin')>Super Admin</option>
                <option value="brand_admin" @selected($role === 'brand_admin')>Brand Admin</option>
                <option value="user" @selected($role === 'user')>User / Staff</option>
            </select>
            <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm px-4 py-2 rounded-xl transition-all">Filter</button>
            @if($search || $role)
                <a href="{{ route('admin.users.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-700 px-2">Clear</a>
            @endif
        </form>
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm px-4 py-2.5 rounded-xl transition-all shadow-md">
            <i data-lucide="user-plus" class="w-4 h-4"></i> Add User
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-left text-[10px] uppercase tracking-wider text-slate-400 font-extrabold">
                    <tr>
                        <th class="px-5 py-3">User</th>
                        <th class="px-5 py-3">Role</th>
                        <th class="px-5 py-3">Brand / Client</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center font-black text-xs uppercase">{{ $user->name[0] }}</div>
                                    <div>
                                        <div class="font-bold text-slate-800">{{ $user->name }}</div>
                                        <div class="text-xs text-slate-400">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3">
                                <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-extrabold border {{ $user->roleBadgeClass() }}">{{ $user->roleLabel() }}</span>
                            </td>
                            <td class="px-5 py-3 text-slate-500 font-semibold">
                                {{ $user->client?->name ?? '—' }}
                            </td>
                            <td class="px-5 py-3">
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-extrabold {{ $user->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $user->is_active ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="p-1.5 text-slate-500 hover:text-brand-600 hover:bg-brand-50 rounded-lg" title="Edit">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.users.toggle-active', $user) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="p-1.5 text-slate-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg" title="{{ $user->is_active ? 'Deactivate' : 'Activate' }}">
                                            <i data-lucide="{{ $user->is_active ? 'user-x' : 'user-check' }}" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete user {{ $user->name }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg" title="Delete">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-10 text-center text-slate-400 text-sm">No users found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
            <div class="px-5 py-3 border-t border-slate-100">{{ $users->links() }}</div>
        @endif
    </div>
</div>
@endsection
