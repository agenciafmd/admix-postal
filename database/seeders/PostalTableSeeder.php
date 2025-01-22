<?php

namespace Agenciafmd\Postal\Database\Seeders;

use Agenciafmd\Postal\Models\Postal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class PostalTableSeeder extends Seeder
{
    public function run(): void
    {
        Postal::query()
            ->truncate();

        $items = $this->items();

        $this->command->getOutput()
            ->progressStart($items->count());

        $items->each(function ($item) {
            Postal::query()
                ->create($item);

            $this->command->getOutput()
                ->progressAdvance();
        });

        $this->command->getOutput()
            ->progressFinish();
    }

    private function items(): Collection
    {
        return collect([
            [
                'name' => 'Contato',
                'subject' => 'Contato',
                'to_name' => 'Agência F&MD',
                'to' => 'irineu@fmd.ag',
            ],
        ]);
    }
}
