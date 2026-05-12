<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Backup;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function index()
{
    $backups = Backup::latest()->get();
    return view('admin.backup.index', compact('backups'));
}

public function store()
{
    $filename = 'backup-' . date('Y-m-d-H-i-s') . '.json';

    $data = [
        'warga' => \App\Models\Warga::all(),
        'keterampilan' => \App\Models\Keterampilan::all(),
    ];

    Storage::put('backup/' . $filename, json_encode($data));

    Backup::create([
        'nama_file' => $filename,
        'file_path' => 'backup/' . $filename
    ]);

    return back()->with('success', 'Backup berhasil dibuat');
}

public function download($id)
{
    $backup = Backup::findOrFail($id);

    return Storage::download($backup->file_path);
}
}
