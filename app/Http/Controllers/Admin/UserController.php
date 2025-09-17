<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        $roles = ['admin', 'dosen', 'reviewer', 'kaprodi', 'auditor'];
        $role = $request->get('role');
        $q = $request->get('q');

        $usersQuery = User::query();

        if ($role && in_array($role, $roles)) {
            $usersQuery->where('role', $role);
        }

        if ($q) {
            $usersQuery->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('email', 'like', "%{$q}%")
                      ->orWhere('nip', 'like', "%{$q}%");
            });
        }

        $users = $usersQuery->orderByDesc('created_at')->paginate(15)->appends($request->query());

        return view('admin.users.index', compact('users', 'roles', 'role', 'q'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = ['admin', 'dosen', 'reviewer', 'kaprodi', 'auditor'];
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'nip' => ['required', 'string', 'max:50', 'unique:users,nip'],
            'role' => ['required', Rule::in(['admin', 'dosen', 'reviewer', 'kaprodi', 'auditor'])],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->nip = $validated['nip'];
        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('users.index')->with('success', 'User berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $roles = ['admin', 'dosen', 'reviewer', 'kaprodi', 'auditor'];
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'nip' => ['required', 'string', 'max:50', Rule::unique('users', 'nip')->ignore($user->id)],
            'role' => ['required', Rule::in(['admin', 'dosen', 'reviewer', 'kaprodi', 'auditor'])],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->nip = $validated['nip'];
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        $user->save();

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Optional: prevent deleting self
        if (auth()->id() === $user->id) {
            return redirect()->route('users.index')->with('error', 'Tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}


