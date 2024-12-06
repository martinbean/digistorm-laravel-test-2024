<?php

namespace Tests\Feature;

use App\Models\Contact;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\TestCase;

class SearchContactsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (! in_array(DatabaseMigrations::class, class_uses_recursive($this))) {
            $this->markTestSkipped(
                'Fulltext search does not work inside transactions. Please use DatabaseMigrations trait instead.',
            );
        }
    }

    #[TestWith(['first_name', 'John'], 'first_name')]
    #[TestWith(['last_name', 'Doe'], 'last_name')]
    #[TestWith(['company_name', 'ACME'], 'company_name')]
    public function test_can_search_contacts_by_field(string $field, string $value): void
    {
        Contact::factory()->createMany([
            ['first_name' => 'John', 'last_name' => 'Doe', 'company_name' => 'ACME'],
            ['first_name' => 'Tony', 'last_name' => 'Stark', 'company_name' => 'Stark Industries'],
        ]);

        $this
            ->search($value)
            ->assertOk()
            ->assertViewHas('contacts', function ($contacts) use ($field, $value): bool {
                $this->assertInstanceOf(LengthAwarePaginator::class, $contacts);
                $this->assertCount(1, $contacts);
                $this->assertEquals($value, $contacts->first()->getAttribute($field));

                return true;
            });
    }

    protected function search(string $term): TestResponse
    {
        return $this->get(
            uri: route('contacts.index') . '?search=' . $term,
        );
    }
}
