<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Models\Backup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AutoBackupDatabase extends Command
{
    protected $signature = 'backup:auto';

    protected $description = 'Backup database otomatis setiap bulan';

    public function handle()
{
    $tables = [
        'backups',
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

        $createTable = DB::select("SHOW CREATE TABLE {$tableName}");

        $sql .= "\nDROP TABLE IF EXISTS {$tableName};\n";
        $sql .= $createTable[0]->{'Create Table'} . ";\n\n";

        $rows = DB::table($tableName)->get();

        foreach ($rows as $row) {

            $values = array_map(function ($value) {

                if ($value === null || $value === '') {
                    return 'NULL';
                }

                return "'" . addslashes($value) . "'";
            }, (array) $row);

            $sql .= "INSERT INTO {$tableName} VALUES (" .
                implode(',', $values) .
                ");\n";
        }

        $sql .= "\n";
    }

    $filename = 'backup-' . now()->format('Y-m-d-H-i-s') . '.sql';

    Storage::put(
        'backup/' . $filename,
        $sql
    );

    Backup::create([
        'nama_file' => $filename,
        'file_path' => 'backup/' . $filename
    ]);

    $this->info('Backup berhasil dibuat: ' . $filename);
}
}