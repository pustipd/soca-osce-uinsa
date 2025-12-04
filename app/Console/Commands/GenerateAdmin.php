<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class GenerateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-admin';

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
        User::first()->delete();

        $user = new User();
        $user->name = "admin";
        $user->email = "admin@yopmail.com";
        $user->password = Hash::make("password");
        $user->save();

        $this->info("Success!");

    }
}
