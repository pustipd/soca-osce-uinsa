<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

use App\Models\Penguji;

class GeneratePasswordPenguji extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-password-penguji';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $list_penguji = Penguji::all();

        foreach($list_penguji as $penguji) {
            $penguji->password = Hash::make($penguji->nidn);
            $penguji->save();
        }

        $this->info("Success!");
    }
}
