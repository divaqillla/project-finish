<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Answer;

class AuditorController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'role' => 'required|string',
        ]);

        $auditor = User::create([
            'name' => $request->name,
            'role' => $request->role,
        ]);

        // Simpan auditor_id ke tabel answers
        Answer::create([
            'auditor_id' => $auditor->id,
            // Tambahkan kolom-kolom lain yang sesuai
        ]);

        return redirect()->back()->with('success', 'Auditor created successfully.');
    }
}
