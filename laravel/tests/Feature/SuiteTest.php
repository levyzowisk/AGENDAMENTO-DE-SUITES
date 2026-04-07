<?php

declare(strict_types=1);

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;


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
