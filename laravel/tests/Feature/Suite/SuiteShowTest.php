<?php

declare(strict_types=1);

namespace Tests\Feature\Suite;

use App\Models\Suite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class SuiteShowTest extends TestCase
{
    use RefreshDatabase;

    public function testReturnsSuiteDetails(): void
    {
        $suite = Suite::factory()->create();

        $response = $this->getJson("/api/suites/{$suite->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $suite->id,
                    'type_suite' => $suite->type_suite,
                    'amount_per_hour' => $suite->amount_per_hour,
                    'available_count' => $suite->available_count,
                    'created_at' => $suite->created_at->toISOString(),
                    'updated_at' => $suite->updated_at->toISOString(),
                ],
            ])
        ;
    }

    public function testReturns404ForNonExistentSuite(): void
    {
        $response = $this->getJson('/api/suites/999');

        $response->assertStatus(404);
    }
}
