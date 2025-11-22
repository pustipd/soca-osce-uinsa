<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

// models
use App\Models\Mahasiswa;
use App\Models\Penguji;
use App\Models\User;

class DevelopmentEnvironment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:dummy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate some data for testing only';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::first();

        if(! $user) {
            $user = new User();
            $user->name = "admin";
            $user->email = "admin@yopmail.com";
            $user->password = "password";
            $user->save();
        }

        $mahasiswa = Mahasiswa::first();

        if(! $mahasiswa) {

            Mahasiswa::insert([
                [
                    'nim' => '2025001',
                    'nama' => 'Ahmad Fauzi',
                    'tahunmasuk' => 2025,
                ],
                [
                    'nim' => '2025002',
                    'nama' => 'Siti Rahma',
                    'tahunmasuk' => 2025,
                ],
                [
                    'nim' => '2025003',
                    'nama' => 'Budi Santoso',
                    'tahunmasuk' => 2024,
                ],
                [
                    'nim' => '2025004',
                    'nama' => 'Nur Aini',
                    'tahunmasuk' => 2023,
                ],
                [
                    'nim' => '2025005',
                    'nama' => 'Rizki Pratama',
                    'tahunmasuk' => 2025,
                ],
            ]);
        }

        $penguji = Penguji::first();

        if(! $penguji) {

            Penguji::insert([
                ['nip' => '197801012005011001', 'nidn' => '123456789', 'nama' => 'Dr. Ahmad Sudirman'],
                ['nip' => '198002152006041002', 'nidn' => '987654321', 'nama' => 'Prof. Siti Rahmah'],
                ['nip' => '197905072007021003', 'nidn' => '112233445', 'nama' => 'Dr. Budi Prasetyo'],
                ['nip' => '198403242008111004', 'nidn' => '556677889', 'nama' => 'Dr. Nur Aisyah'],
                ['nip' => '198601192010121005', 'nidn' => '667788990', 'nama' => 'Dr. Rizki Hidayat'],
                ['nip' => '197903112003091006', 'nidn' => '334455667', 'nama' => 'Prof. Bambang Setiawan'],
                ['nip' => '198705052009061007', 'nidn' => '778899001', 'nama' => 'Dr. Melati Purnama'],
            ]);
        }

        $this->info("Success!");

    }
}
