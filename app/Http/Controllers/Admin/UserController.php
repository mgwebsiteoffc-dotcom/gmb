<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * List every platform user (super admins, brand admins, and staff).
     */
    public function index(Request $request)
    {
        $role = $request->get('role');
        $search = trim($request->get('q', ''));

        $users = User::with('client')
            ->when($role, fn ($q) => $q->where('role', $role))
            ->when($search, fn ($q) => $q
                ->where(fn ($qq) => $qq
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        $clients = Client::orderBy('name')->get();

        return view('admin.users.index', compact('users', 'clients', 'role', 'search'));
    }

    public function create()
    {
        $clients = Client::orderBy('name')->get();

        return view('admin.users.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in([User::ROLE_SUPER_ADMIN, User::ROLE_BRAND_ADMIN, User::ROLE_USER])],
            'client_id' => ['nullable', 'integer', 'exists:clients,id'],
            'is_active' => ['nullable', 'boolean'],
            'avatar' => ['nullable', 'url', 'max:2048'],
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['is_active'] = $request->boolean('is_active');

        // Brand admins must be scoped to a client.
        if ($data['role'] === User::ROLE_BRAND_ADMIN && empty($data['client_id'])) {
            return back()->withInput()->withErrors([
                'client_id' => 'A brand admin must be assigned to a client/brand.',
            ]);
        }

        User::create($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User "'.$request->name.'" created successfully.');
    }

    public function edit(User $user)
    {
        $clients = Client::orderBy('name')->get();

        return view('admin.users.edit', compact('user', 'clients'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in([User::ROLE_SUPER_ADMIN, User::ROLE_BRAND_ADMIN, User::ROLE_USER])],
            'client_id' => ['nullable', 'integer', 'exists:clients,id'],
            'is_active' => ['nullable', 'boolean'],
            'avatar' => ['nullable', 'url', 'max:2048'],
        ]);

        if ($data['role'] === User::ROLE_BRAND_ADMIN && empty($data['client_id'])) {
            return back()->withInput()->withErrors([
                'client_id' => 'A brand admin must be assigned to a client/brand.',
            ]);
        }

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['is_active'] = $request->boolean('is_active');

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User "'.$request->name.'" updated.');
    }

    public function toggleActive(User $user)
    {
        $user->update(['is_active' => ! $user->is_active]);

        return back()->with('success', 'User "'.$user->name.'" '.($user->is_active ? 'activated' : 'deactivated').'.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['You cannot delete your own account.']);
        }

        $user->delete();

        return back()->with('success', 'User "'.$user->name.'" deleted.');
    }
}
