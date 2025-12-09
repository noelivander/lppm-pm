<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Schema;

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

        $usersQuery = User::with(['jurusan', 'programStudi']);

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
        $jurusans = \App\Models\Jurusan::orderBy('nama')->get();
        $programStudis = \App\Models\ProgramStudi::orderBy('nama')->get();
        return view('admin.users.create', compact('roles', 'jurusans', 'programStudis'));
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
            'jurusan_id' => ['nullable', 'exists:jurusan,id'],
            'program_studi_id' => ['nullable', 'exists:program_studi,id'],
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->nip = $validated['nip'];
        $user->password = Hash::make($validated['password']);
        
        // Only save jurusan and program studi for dosen role, and only if columns exist
        if ($validated['role'] === 'dosen' && Schema::hasColumn('users', 'jurusan_id')) {
            $user->jurusan_id = $validated['jurusan_id'] ?? null;
            $user->program_studi_id = $validated['program_studi_id'] ?? null;
        }
        
        $user->save();

        return redirect()->route('users.index')->with('success', 'User berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $roles = ['admin', 'dosen', 'reviewer', 'kaprodi', 'auditor'];
        $jurusans = \App\Models\Jurusan::orderBy('nama')->get();
        $programStudis = \App\Models\ProgramStudi::orderBy('nama')->get();
        return view('admin.users.edit', compact('user', 'roles', 'jurusans', 'programStudis'));
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
            'jurusan_id' => ['nullable', 'exists:jurusan,id'],
            'program_studi_id' => ['nullable', 'exists:program_studi,id'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->nip = $validated['nip'];
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        
        // Only save jurusan and program studi for dosen role, and only if columns exist
        if (Schema::hasColumn('users', 'jurusan_id')) {
            if ($validated['role'] === 'dosen') {
                $user->jurusan_id = $validated['jurusan_id'] ?? null;
                $user->program_studi_id = $validated['program_studi_id'] ?? null;
            } else {
                // Clear jurusan and program studi if role is changed from dosen to something else
                $user->jurusan_id = null;
                $user->program_studi_id = null;
            }
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


