<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'superadmin'])) {
                return redirect()->route('home');
            }
            return $next($request);
        });
    }

    // Dashboard for admins
    public function dashboard()
    {
        $admins = User::where('role', 'admin')->get();
        return view('admin.dashboard', compact('admins'));
    }

    // Create admin (only superadmin)
    public function createAdmin(Request $request)
    {
        if (auth()->user()->role !== 'superadmin') {
            return redirect()->route('admin.dashboard');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Admin created successfully.');
    }

    // Delete admin (only superadmin)
    public function deleteAdmin($id)
    {
        if (auth()->user()->role !== 'superadmin') {
            return redirect()->route('admin.dashboard');
        }

        $admin = User::where('role', 'admin')->findOrFail($id);
        $admin->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Admin deleted successfully.');
    }
}
