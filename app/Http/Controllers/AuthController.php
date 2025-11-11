<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Proses login pengguna.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'role'     => 'required', // ✅ role wajib diisi
        ]);

        // Validasi checkbox Remember Me
        if (!$request->has('remember')) {
            return back()->with('error', 'Anda harus mencentang "Remember Me" untuk login.');
        }

        // Cari user berdasarkan username
        $user = User::where('username', $request->username)->first();

        // Verifikasi password dan role
        if ($user && Hash::check($request->password, $user->password)) {

            // ✅ Cek apakah role yang dipilih sama dengan role user di database
            if ($user->role !== $request->role) {
                return back()->with('error', 'Role yang dipilih tidak sesuai dengan akun Anda.');
            }

            // Simpan data user ke session
            session([
                'id_user'    => $user->iduser,
                'role'       => $user->role,
                'nama_user'  => $user->nama_user,
            ]);

            // Arahkan sesuai role
            switch ($user->role) {
                case 'administrator':
                    return redirect('/admin/dashboard');
                case 'waiter':
                    return redirect('/waiter/dashboard');
                case 'kasir':
                    return redirect('/kasir/dashboard');
                case 'owner':
                    return redirect('/owner/dashboard');
                default:
                    return redirect('/login')->with('error', 'Role tidak dikenali.');
            }
        }

        // Jika login gagal
        return back()->with('error', 'Username atau password salah!');
    }

    /**
     * Logout pengguna dan hapus session.
     */
    public function destroy()
    {
        session()->flush();
        return redirect('/login');
    }

    /**
     * Tampilkan form reset password.
     */
    public function resetForm()
    {
        return view('auth.reset');
    }

    /**
     * Proses reset password.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return back()->with('error', 'Username tidak ditemukan.');
        }

        $user->password = bcrypt($request->new_password);
        $user->save();

        return redirect('/login')->with('success', 'Password berhasil diubah. Silakan login kembali.');
    }
}
