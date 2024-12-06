<?php

namespace Tests\Feature;

use App\Models\Contact;
use Illuminate\Support\Arr;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\TestCase;

class CreateContactTest extends TestCase
{
    public function test_can_view_create_contact_form(): void
    {
        $this
            ->get('/contacts/create')
            ->assertOk()
            ->assertViewIs('contacts.create');
    }

    public function test_can_create_contact_with_phone_number(): void
    {
        $this->assertDatabaseEmpty('contacts');
        $this->assertDatabaseEmpty('phone_numbers');

        $this
            ->post('/contacts', [
                'first_name' => $firstName = fake()->firstName(),
                'last_name' => $lastName = fake()->lastName(),
                'DOB' => $dob = fake()->dateTimeBetween('-65 years', '-18 years')->format('Y-m-d'),
                'company_name' => $companyName = fake()->company(),
                'position' => 'Director',
                'email' => $email = fake()->safeEmail(),
                'number' => [
                    $phoneNumber = fake()->e164PhoneNumber(),
                ],
            ])
            ->assertValid()
            ->assertRedirect();

        $this->assertDatabaseHas('contacts', [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'DOB' => $dob,
            'company_name' => $companyName,
            'position' => 'Director',
            'email' => $email,
        ]);

        $contact = Contact::query()->latest()->firstOr(fn () => $this->fail('Contact not found.'));

        $this->assertDatabaseHas('phone_numbers', [
            'contact_id' => $contact->getKey(),
            'number' => $phoneNumber,
        ]);
    }

    #[TestWith(['first_name'], 'first_name')]
    #[TestWith(['last_name'], 'last_name')]
    #[TestWith(['company_name'], 'company_name')]
    #[TestWith(['position'], 'position')]
    #[TestWith(['number'], 'number')]
    public function test_field_is_required(string $field): void
    {
        $data = [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'DOB' => fake()->dateTimeBetween('-65 years', '-18 years')->format('Y-m-d'),
            'company_name' => fake()->company(),
            'position' => 'Director',
            'email' => fake()->safeEmail(),
            'number' => [
                fake()->e164PhoneNumber(),
            ],
        ];

        $this
            ->post('/contacts', Arr::except($data, $field))
            ->assertInvalid($field);
    }

    public function test_dob_must_be_valid_date(): void
    {
        $this
            ->post('/contacts', [
                'first_name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'DOB' => 'yesterday',
                'company_name' => fake()->company(),
                'position' => 'Director',
                'email' => fake()->safeEmail(),
                'number' => [
                    fake()->e164PhoneNumber(),
                ],
            ])
            ->assertInvalid('DOB');
    }

    public function test_email_must_be_valid(): void
    {
        $this
            ->post('/contacts', [
                'first_name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'DOB' => fake()->dateTimeBetween('-65 years', '-18 years')->format('Y-m-d'),
                'company_name' => fake()->company(),
                'position' => 'Director',
                'email' => 'john.doe',
                'number' => [
                    fake()->e164PhoneNumber(),
                ],
            ])
            ->assertInvalid('email');
    }
}
