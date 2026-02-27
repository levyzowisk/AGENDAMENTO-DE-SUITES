<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class SuiteTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/api/suites');

        $response->assertStatus(200);
    }

    public function test_must_return_array(): void 
    {
        $response = $this->get('/api/suites');


        $response->assertJsonIsArray();
    }

    public function test_must_return_array_with_correct_keys(): void 
    {
        $response = $this->get('/api/suites');

        $response->assertJsonStructure([
            '*' => [
                'id',
                'type',
                'features',
                'amountPerHour',
                'availableCount',
            ]
        ]);
    }

    public function test_suites_have_correct_structure_and_types(): void
    {
        $response = $this->getJson('/api/suites');

        $response->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json->each(fn (AssertableJson $suite) =>
                    $suite->whereType('id', 'integer')
                        ->whereType('type', 'string')
                        ->whereType('amountPerHour', ['integer', 'double'])
                        ->whereType('availableCount', 'integer')
                        ->whereType('features', 'array')
                )
            );
    }

    /**
     * Testa se a rota /suites/map retorna sucesso
     */
    public function test_suite_map_returns_successful_response(): void
    {
        $response = $this->get('/api/suites/map');

        $response->assertStatus(200);
    }

    /**
     * Testa se /suites/map retorna um array
     */
    public function test_suite_map_must_return_array(): void 
    {
        $response = $this->get('/api/suites/map');

        $response->assertJsonIsArray();
    }
}

