<?php

namespace App\Console\Commands;

use App\Http\Controllers\Api\UpdateController;
use Illuminate\Console\Command;

class UpdateUsersCommand extends Command
{
    protected $signature = 'update-users';

    protected $description = 'Sync json users';

    public function handle()
    {
        (new UpdateController())->createOrUpdateUsers();
    }
}
