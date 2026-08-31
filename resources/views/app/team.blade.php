@extends('layouts.app')

@section('title', 'Team & Granular Permissions - Ampli5 Pulse')

@section('content')
<div class="space-y-6" x-data="{ isInviteOpen: false }">
    <!-- Header -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs font-bold text-brand-600 bg-brand-50 px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                    Role-Based Access Control
                </span>
                <span class="text-xs text-slate-400 font-medium">Granular module permissions</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 font-display">
                Team & Client Access Management
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                Assign team members and clients to specific locations and modules with custom permission gates.
            </p>
        </div>

        <button
            @click="isInviteOpen = true"
            class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs sm:text-sm px-4 py-2.5 rounded-xl transition-all shadow-md flex items-center gap-2"
        >
            <i data-lucide="user-plus" class="w-4 h-4"></i> Invite Team Member / Client
        </button>
    </div>

    <!-- Team Members Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px] border-b border-slate-100">
                    <tr>
                        <th class="py-3 px-4">User</th>
                        <th class="py-3 px-3">Role</th>
                        <th class="py-3 px-3">Module Permissions</th>
                        <th class="py-3 px-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @foreach($team as $member)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <img
                                        src="{{ $member->avatar }}"
                                        alt="{{ $member->name }}"
                                        class="w-10 h-10 rounded-full object-cover border border-slate-200"
                                    />
                                    <div>
                                        <div class="font-bold text-slate-900">{{ $member->name }}</div>
                                        <div class="text-[11px] text-slate-400">{{ $member->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-3">
                                <span class="font-bold text-slate-800 bg-slate-100 px-2.5 py-1 rounded-lg">
                                    {{ $member->role }}
                                </span>
                            </td>
                            <td class="py-3.5 px-3">
                                <div class="flex flex-wrap gap-1">
                                    @if($member->permissions['posts'] ?? false)
                                        <span class="text-[10px] bg-blue-50 text-blue-700 px-2 py-0.5 rounded font-bold">Posts</span>
                                    @endif
                                    @if($member->permissions['reviews'] ?? false)
                                        <span class="text-[10px] bg-amber-50 text-amber-700 px-2 py-0.5 rounded font-bold">Reviews</span>
                                    @endif
                                    @if($member->permissions['media'] ?? false)
                                        <span class="text-[10px] bg-purple-50 text-purple-700 px-2 py-0.5 rounded font-bold">Media</span>
                                    @endif
                                    @if($member->permissions['reports'] ?? false)
                                        <span class="text-[10px] bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded font-bold">Reports</span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3.5 px-3">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Invite Modal -->
    <div
        x-show="isInviteOpen"
        x-transition
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4"
        style="display: none;"
    >
        <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-200 overflow-hidden" @click.away="isInviteOpen = false">
            <div class="bg-gradient-to-r from-brand-700 to-indigo-800 p-5 text-white flex items-center justify-between">
                <h3 class="font-bold text-base font-display">Invite Team Member / Client</h3>
                <button @click="isInviteOpen = false" class="text-white text-xl font-bold leading-none">✕</button>
            </div>

            <form action="{{ route('app.team.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Full Name</label>
                    <input type="text" name="name" required class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Email Address</label>
                    <input type="email" name="email" required class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Role</label>
                    <select name="role" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold bg-white">
                        <option value="Local SEO Specialist">Local SEO Specialist</option>
                        <option value="Account Manager">Account Manager</option>
                        <option value="Review Responder">Review Responder</option>
                        <option value="Client View-Only">Client View-Only</option>
                    </select>
                </div>

                <div class="space-y-1.5 pt-2 border-t border-slate-100">
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Module Permissions:</label>
                    <label class="flex items-center gap-2 text-xs text-slate-600">
                        <input type="checkbox" name="perm_posts" checked class="rounded text-brand-600">
                        <span>Publish & Schedule Google Posts</span>
                    </label>
                    <label class="flex items-center gap-2 text-xs text-slate-600">
                        <input type="checkbox" name="perm_reviews" checked class="rounded text-brand-600">
                        <span>Answer Reviews with AI Assistant</span>
                    </label>
                    <label class="flex items-center gap-2 text-xs text-slate-600">
                        <input type="checkbox" name="perm_media" checked class="rounded text-brand-600">
                        <span>Upload & Geotag Media Photos</span>
                    </label>
                    <label class="flex items-center gap-2 text-xs text-slate-600">
                        <input type="checkbox" name="perm_reports" checked class="rounded text-brand-600">
                        <span>View & Export White-Label Reports</span>
                    </label>
                </div>

                <div class="pt-3 flex justify-between items-center border-t border-slate-100">
                    <button type="button" @click="isInviteOpen = false" class="text-xs font-bold text-slate-500">Cancel</button>
                    <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-md">
                        Send Invitation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
