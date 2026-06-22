<?php

namespace App\Http\Controllers;

use App\Models\Backup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class BackupController extends Controller
{
    public function index()
    {
        $backups = Backup::latest()->paginate(20);
        return view('admin.backup.index', compact('backups'));
    }

    public function store()
    {
        $tables = [
    'dusuns',
    'rws',
    'rts',
    'users',
    'wargas',
    'kategori_keterampilans',
    'keterampilans',
    'pesans'
];

        $sql = '';

        foreach ($tables as $tableName) {
            // Struktur tabel
            $createTable = DB::select("SHOW CREATE TABLE {$tableName}");
            $sql .= "\nDROP TABLE IF EXISTS {$tableName};\n";
            $sql .= $createTable[0]->{'Create Table'} . ";\n\n";

            // Isi tabel
            $rows = DB::table($tableName)->get();
            foreach ($rows as $row) {
                $values = array_map(function ($value) {
                    if ($value === null || $value === '') {
                        return 'NULL';
                    }
                    return "'" . addslashes($value) . "'";
                }, (array) $row);

                $sql .= "INSERT INTO {$tableName} VALUES (" . implode(',', $values) . ");\n";
            }
            $sql .= "\n";
        }

        $filename = 'backup-' . now()->format('Y-m-d-H-i-s') . '.sql';
        if (!Storage::exists('backup')) {
    Storage::makeDirectory('backup');
}
        Storage::put('backup/' . $filename, $sql);

        Backup::create([
            'nama_file' => $filename,
            'file_path' => 'backup/' . $filename
        ]);

        return back()->with([
    'success' => 'Backup berhasil dibuat',
    'backup_file' => $filename,
    'jumlah_tabel' => count($tables)
    ]);
    }

    public function download($id)
    {
        $backup = Backup::findOrFail($id);
        return Storage::download($backup->file_path);
    }

    public function restore($id)
    {
        $backup = Backup::findOrFail($id);

        if (!Storage::exists($backup->file_path)) {
            return back()->with('error', 'File backup tidak ditemukan.');
        }

        $sql = Storage::get($backup->file_path);

        try {
            DB::unprepared("
                SET FOREIGN_KEY_CHECKS=0;
                {$sql}
                SET FOREIGN_KEY_CHECKS=1;
            ");
            $backup->update([
                'last_restored_at' => now()
            ]);
            return redirect()
                ->route('admin.backup.index')
                ->with('success', 'Database berhasil direstore.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.backup.index')
                ->with('error', 'Restore gagal: ' . $e->getMessage());
        }
    }
}
