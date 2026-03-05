<?php

namespace Tests\Feature\Suite;

use App\Models\Suite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SuiteUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_update_all_fields_of_suite_successfully(): void
    {
        $suite = Suite::factory()->create([
            'type_suite' => 'Quartinho Antigo',
            'amount_per_hour' => 100.00,
        ]);

        $payload = [
            'type_suite' => 'Quartinho Reformado',
            'amount_per_hour' => 150.00,
        ];

        $response = $this->patchJson("/api/suites/{$suite->id}", $payload);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'type_suite' => 'Quartinho Reformado',
                     'amount_per_hour' => "150.00",
                 ]);

        $this->assertDatabaseHas('suites', [
            'id' => $suite->id,
            'type_suite' => 'Quartinho Reformado',
            'amount_per_hour' => "150.00",
        ]);
    }


    public function test_should_update_partial_fields_of_suite_successfully(): void
    {
        $suite = Suite::factory()->create([
            'type_suite' => 'Quartinho do Amor',
            'amount_per_hour' => 100.00,
        ]);

        $payload = [
            'amount_per_hour' => 200.00, 
        ];

        $response = $this->patchJson("/api/suites/{$suite->id}", $payload);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'type_suite' => 'Quartinho do Amor', 
                     'amount_per_hour' => "200.00", 
                 ]);

        $this->assertDatabaseHas('suites', [
            'id' => $suite->id,
            'type_suite' => 'Quartinho do Amor',
            'amount_per_hour' => "200.00",
        ]);
    }

  
    public function test_should_not_update_with_invalid_data_types(): void
    {
        $suite = Suite::factory()->create();

        $payload = [
            'amount_per_hour' => 'nao_eh_numero', 
        ];

        $response = $this->patchJson("/api/suites/{$suite->id}", $payload);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['amount_per_hour']);
    }


    public function test_should_return_404_when_updating_non_existent_suite(): void
    {
        $payload = [
            'type_suite' => 'Quartinho Fantasma',
        ];

        $response = $this->patchJson("/api/suites/9999", $payload);

        $response->assertStatus(404);
    }
}