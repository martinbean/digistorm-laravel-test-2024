<?php

namespace Tests\Feature;

use App\Models\Contact;
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

    public function test_can_create_contact_without_phone_number(): void
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
                    '',
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

        $this->assertDatabaseEmpty('phone_numbers');
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
                    $phoneNumber = fake()->phoneNumber(),
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
}
