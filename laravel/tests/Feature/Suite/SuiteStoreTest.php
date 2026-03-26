<?php

namespace Tests\Feature\Suite;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Suite;

class SuiteStoreTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_should_store_suite_successfully(): void
    {
        $payload = [
            'type_suite' => 'Quartinho do Amor',
            'amount_per_hour' => 150.90,
            'available_count' => 20
        ];

        $response = $this->postJson('/api/suites', $payload);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'id',
                     'type_suite',
                     'amount_per_hour',
                     'available_count'
                 ])
                 ->assertJsonFragment([
                     'type_suite' => 'Quartinho do Amor',
                     'available_count' => 20
                 ]);

        $this->assertDatabaseHas('suites', [
            'type_suite' => 'Quartinho do Amor',
        ]);

        
        $this->assertDatabaseCount('suite_units', 20);
        $this->assertDatabaseHas('suite_units', [
            'status' => 'FREE',
        ]);
    }


    public function test_should_not_store_suite_without_required_fields(): void
    {
        $payload = [];

        $response = $this->postJson('/api/suites', $payload);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors([
                     'type_suite',
                     'amount_per_hour',
                     'available_count'
                 ]);

        $this->assertDatabaseEmpty('suites');
    }


    public function test_should_not_store_suite_with_invalid_data_types(): void
    {
        $payload = [
            'type_suite' => 123, // Espera string
            'amount_per_hour' => 'invalid_amount', // Espera numeric
            'available_count' => 'invalid_count' // Espera integer
        ];

        $response = $this->postJson('/api/suites', $payload);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors([
                     'type_suite',
                     'amount_per_hour',
                     'available_count'
                 ]);
                 
        $this->assertDatabaseEmpty('suites');
    }
}