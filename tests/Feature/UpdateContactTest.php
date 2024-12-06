<?php

namespace Tests\Feature;

use App\Models\Contact;
use Illuminate\Support\Arr;
use PHPUnit\Framework\Attributes\TestWith;
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
        $contact = Contact::factory()->create();

        $data = [
            'first_name' => $firstName = fake()->firstName(),
            'last_name' => $lastName = fake()->lastName(),
            'DOB' => $dob = fake()->dateTimeBetween('-65 years', '-18 years')->format('Y-m-d'),
            'company_name' => $companyName = fake()->company(),
            'position' => 'Director',
            'email' => $email = fake()->safeEmail(),
            'number' => [
                $phoneNumber = fake()->e164PhoneNumber(),
            ],
        ];

        $this
            ->put(route('contacts.update', compact('contact')), data: Arr::except($data, $field))
            ->assertInvalid($field);
    }
}
