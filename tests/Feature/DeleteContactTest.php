<?php

namespace Tests\Feature;

use App\Models\Contact;
use Tests\TestCase;

class DeleteContactTest extends TestCase
{
    public function test_can_delete_contact(): void
    {
        $contact = Contact::factory()->create();

        $this
            ->delete(route('contacts.destroy', compact('contact')))
            ->assertRedirectToRoute('contacts.index');

        $this->assertModelMissing($contact);
    }
}
