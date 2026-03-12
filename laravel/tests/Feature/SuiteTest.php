<?php

declare(strict_types=1);

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class SuiteTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testTheApplicationReturnsASuccessfulResponse(): void
    {
        $response = $this->get('/api/suites');

        $response->assertStatus(200);
    }

    public function testMustReturnArray(): void
    {
        $response = $this->get('/api/suites');

        $response->assertJsonIsArray();
    }

    public function testMustReturnArrayWithCorrectKeys(): void
    {
        $response = $this->get('/api/suites');

        $response->assertJsonStructure([
            '*' => [
                'id',
                'type',
                'features',
                'amountPerHour',
                'availableCount',
            ],
        ]);
    }

    public function testSuitesHaveCorrectStructureAndTypes(): void
    {
        $response = $this->getJson('/api/suites');

        $response->assertOk()
            ->assertJson(
                fn (AssertableJson $json) => $json->each(
                    fn (AssertableJson $suite) => $suite->whereType('id', 'integer')
                        ->whereType('type', 'string')
                        ->whereType('amountPerHour', ['integer', 'double'])
                        ->whereType('availableCount', 'integer')
                        ->whereType('features', 'array')
                )
            )
        ;
    }

    /**
     * Testa se a rota /suites/map retorna sucesso.
     */
    public function testSuiteMapReturnsSuccessfulResponse(): void
    {
        $response = $this->get('/api/suites/map');

        $response->assertStatus(200);
    }

    /**
     * Testa se /suites/map retorna um array.
     */
    public function testSuiteMapMustReturnArray(): void
    {
        $response = $this->get('/api/suites/map');

        $response->assertJsonIsArray();
    }
}
