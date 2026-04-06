<?php

declare(strict_types=1);

namespace Tests\Feature\Suite;

use App\Models\Suite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class SuiteIndexTest extends TestCase
{
    use RefreshDatabase;

    public function testReturnsEmptyListWhenNoSuites(): void
    {
        $response = $this->getJson('/api/suites');

        $response->assertStatus(200)
            ->assertJson(['data' => []])
        ;
    }

    public function testReturnsListOfSuitesWithExpectedFields(): void
    {
        Suite::factory()->count(2)->create();

        $response = $this->getJson('/api/suites');

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'type_suite',
                        'amount_per_hour',
                        'available_count',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ])
        ;
    }
}
