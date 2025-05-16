<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportManualEmbeddings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'embeddings:import {file=manual_embeddings.json}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import manual embeddings from a JSONL file into the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = base_path($this->argument('file'));

        if (! file_exists($path)) {
            $this->error("File does not exist: {$path}");

            return 1;
        }

        $this->info("Importing from: $path");

        DB::beginTransaction();

        try {
            $handle = fopen($path, 'r');

            while (($line = fgets($handle)) !== false) {
                $entry = json_decode($line, true);

                DB::table('manual_chunks')->updateOrInsert(
                    ['id' => $entry['id']],
                    [
                        'text' => $entry['text'],
                        'embedding' => json_encode($entry['embedding']),
                        'brand' => $entry['brand'] ?? null,
                        'model' => $entry['model'] ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }

            fclose($handle);
            DB::commit();

            $this->info("✅ Embeddings imported successfully.");
            return 0;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("❌ Error importing embeddings: {$e->getMessage()}");
            return 1;
        }
    }
}
