<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\PhoneNumber;
use Tests\TestCase;

class UpdateContactTest extends TestCase
{
    public function test_can_view_edit_contact_form(): void
    {
        $contact = Contact::factory()->create();

        $this
            ->get(route('contacts.edit', compact('contact')))
            ->assertOk()
            ->assertViewIs('contacts.edit')
            ->assertViewHas('contact', $contact);
    }

    public function test_can_update_contact(): void
    {
        $contact = Contact::factory()->create();

        $this
            ->put(route('contacts.update', compact('contact')), data: [
                'first_name' => $firstName = fake()->firstName(),
                'last_name' => $lastName = fake()->lastName(),
                'DOB' => $dob = fake()->dateTimeBetween('-65 years', '-18 years')->format('Y-m-d'),
                'company_name' => $companyName = fake()->company(),
                'position' => 'Director',
                'email' => $email = fake()->safeEmail(),
            ])
            ->assertValid();

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->getKey(),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'DOB' => $dob,
            'company_name' => $companyName,
            'position' => 'Director',
            'email' => $email,
        ]);
    }

    public function test_existing_phone_number_is_removed(): void
    {
        $contact = Contact::factory()->create();
        $phoneNumber = PhoneNumber::factory()->for($contact)->create();

        $this
            ->put(route('contacts.update', compact('contact')), data: [
                'first_name' => $firstName = fake()->firstName(),
                'last_name' => $lastName = fake()->lastName(),
                'DOB' => $dob = fake()->dateTimeBetween('-65 years', '-18 years')->format('Y-m-d'),
                'company_name' => $companyName = fake()->company(),
                'position' => 'Director',
                'email' => $email = fake()->safeEmail(),
            ])
            ->assertValid()
            ->assertRedirectToRoute('contacts.show', compact('contact'));

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->getKey(),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'DOB' => $dob,
            'company_name' => $companyName,
            'position' => 'Director',
            'email' => $email,
        ]);

        $this->assertModelMissing($phoneNumber);
    }

    public function test_new_phone_numbers_are_saved(): void
    {
        $contact = Contact::factory()->create();

        $this->assertDatabaseCount('phone_numbers', 1);

        $this
            ->put(route('contacts.update', compact('contact')), data: [
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
            ->assertRedirectToRoute('contacts.show', compact('contact'));

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->getKey(),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'DOB' => $dob,
            'company_name' => $companyName,
            'position' => 'Director',
            'email' => $email,
        ]);

        $this->assertDatabaseCount('phone_numbers', 1);
        $this->assertDatabaseHas('phone_numbers', [
            'contact_id' => $contact->getKey(),
            'number' => $phoneNumber,
        ]);
    }
}
