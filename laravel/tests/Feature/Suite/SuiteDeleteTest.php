<?php

declare(strict_types=1);

namespace Tests\Feature\Suite;

use App\Models\Suite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SuiteDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldDeleteSuiteSuccessfully(): void
    {
        $suite = Suite::factory()->create();

        $response = $this->deleteJson("/api/suites/{$suite->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('suites', [
            'id' => $suite->id,
        ]);

        $this->assertDatabaseMissing('suite_units', [
            'suite_id' => $suite->id,
        ]);
    }

    public function testShouldReturn404WhenDeletingNonExistentSuite(): void
    {
        $idInexistente = 9999;

        $response = $this->deleteJson("/api/suites/{$idInexistente}");

        $response->assertStatus(404);
    }
}
