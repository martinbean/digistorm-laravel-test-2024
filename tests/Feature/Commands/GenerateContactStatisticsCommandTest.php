<?php

namespace Tests\Feature\Commands;

use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GenerateContactStatisticsCommandTest extends TestCase
{
    public function test_command_generates_statistics_for_current_day_by_default(): void
    {
        Date::setTestNow(Date::createFromDate(2023, 12, 1));

        $this->freezeSecond(function (): void {
            Storage::fake();

            $path = sprintf('logs/contacts/%s.json', Date::today()->format('Y-m-d'));

            Storage::assertMissing($path);

            $this
                ->artisan('contact:statistics')
                ->assertSuccessful();

            Storage::assertExists($path);
        });
    }

    public function test_can_generate_statistics_for_specific_day(): void
    {
        Storage::fake();

        $path = 'logs/contacts/2020-01-01.json';

        Storage::assertMissing($path);

        $this
            ->artisan('contact:statistics', [
                'date' => '2020-01-01',
            ])
            ->assertSuccessful();

        Storage::assertExists($path);
    }

    public function test_date_must_be_formatted_correctly(): void
    {
        Storage::fake();

        $this
            ->artisan('contact:statistics', [
                'date' => 'today',
            ])
            ->assertFailed();

        Storage::assertDirectoryEmpty('logs/contacts');
    }
}
