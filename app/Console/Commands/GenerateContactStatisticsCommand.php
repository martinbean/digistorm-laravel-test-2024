<?php

namespace App\Console\Commands;

use App\Models\Contact;
use Carbon\Exceptions\InvalidFormatException;
use DateTimeInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;

class GenerateContactStatisticsCommand extends Command
{
    /**
     * {@inheritDoc}
     */
    protected $signature = 'contact:statistics {date? : Must be in the format YYYY-MM-DD. Defaults to current date.}';

    /**
     * {@inheritDoc}
     */
    protected $description = 'Calculate how many contacts were created and updated on a single date';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $date = $this->parseDateArgument();

        $contactsCreated = Contact::query()->whereDate('created_at', $date)->count();
        $contactsUpdated = Contact::query()->whereDate('updated_at', $date)->count();

        $this->components->twoColumnDetail('Contacts created today', $contactsCreated);
        $this->components->twoColumnDetail('Contacts updated today', $contactsUpdated);

        $this->writeStatisticsToFile($date, $contactsCreated, $contactsUpdated);

        return Command::SUCCESS;
    }

    /**
     * Parse the date argument, if one was supplied.
     */
    protected function parseDateArgument(): DateTimeInterface
    {
        if ($date = $this->argument('date')) {
            try {
                return Date::createFromFormat('Y-m-d', $date);
            } catch (InvalidFormatException) {
                $this->fail('Date argument should use the format YYYY-MM-DD.');
            }
        }

        return Date::today();
    }

    /**
     * Write the given created and updated statistics to a file.
     */
    protected function writeStatisticsToFile(DateTimeInterface $date, int $created, int $updated): bool
    {
        return Storage::put(
            path: sprintf('logs/contacts/%s.json', $date->format('Y-m-d')),
            contents: json_encode([
                'created' => $created,
                'updated' => $updated,
            ]),
        );;
    }
}
