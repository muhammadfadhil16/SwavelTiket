<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $role = $request->get('role');

        $users = User::query()
            ->when($search, function ($query, $search) {
                return $query->where('name_user', 'like', '%' . $search . '%')
                             ->orWhere('email_user', 'like', '%' . $search . '%');
            })
            ->when($role, function ($query, $role) {
                return $query->where('role', $role);
            })
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }


    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('users.index');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        // Cari user berdasarkan ID
        $user = User::findOrFail($id);

        // Validasi input
        $request->validate([
            'role' => 'required|in:Admin,User,Promotor',
        ]);

        // Update data role
        $user->role = $request->input('role'); // Pastikan nilai role sesuai
        $user->save(); // Simpan perubahan

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }



    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index');
    }
}
