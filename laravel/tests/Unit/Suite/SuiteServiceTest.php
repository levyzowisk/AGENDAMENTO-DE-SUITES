<?php

namespace Tests\Unit\Suite;

use App\Contracts\Suite\SuiteRepositoryInterface;
use App\Models\Suite;
use App\Service\SuiteService;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SuiteServiceTest extends TestCase
{
    private $repositoryMock;
    private $suiteService;

    /**
     * Configura o ambiente antes de CADA teste.
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        // Criação do mock (Dublê) do repositório
        $this->repositoryMock = Mockery::mock(SuiteRepositoryInterface::class);
        
        // Injeção da dependência falsa no Service real que queremos testar
        $this->suiteService = new SuiteService($this->repositoryMock);
    }

    /**
     * Limpa os mocks da memória ao final de cada teste.
     */
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_should_return_all_suites(): void
    {
        // 1. Prepara dados falsos
        $collection = new Collection([new Suite(), new Suite()]);

        // 2. Ensina o Mock o que ele deve retornar
        $this->repositoryMock->shouldReceive('all')
            ->once()
            ->andReturn($collection);

        // 3. Executa a Ação
        $result = $this->suiteService->getAllSuites();

        // 4. Afirmações (Assertions)
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(2, $result);
    }

    public function test_should_return_suite_by_id_when_exists(): void
    {
        $suiteMock = new Suite();
        $suiteMock->id = 1;

        $this->repositoryMock->shouldReceive('show')
            ->with(1) // Garante que a ID repassada ao mock foi a ID 1
            ->once()  // Garante que o método será chamado 1 vez certinha
            ->andReturn($suiteMock);

        $result = $this->suiteService->show(1);

        $this->assertInstanceOf(Suite::class, $result);
        $this->assertEquals(1, $result->id);
    }

    public function test_should_throw_exception_when_suite_not_found(): void
    {
        // Aqui simulamos uma busca no banco que retorna null
        $this->repositoryMock->shouldReceive('show')
            ->with(99)
            ->once()
            ->andReturn(null);

        // Indicamos que ESPERAMOS que ele lance esse erro! Se não lançar, o teste falha.
        $this->expectException(NotFoundHttpException::class);

        $this->suiteService->show(99);
    }

    public function test_should_store_suite_successfully(): void
    {
        $data = [
            'type_suite' => 'Quarto Super', 
            'amount_per_hour' => 120.00
        ];
        
        $suiteMock = new Suite($data);

        $this->repositoryMock->shouldReceive('store')
            ->with($data)
            ->once()
            ->andReturn($suiteMock);

        $result = $this->suiteService->store($data);

        $this->assertInstanceOf(Suite::class, $result);
        $this->assertEquals('Quarto Super', $result->type_suite);
    }

    public function test_should_update_suite_successfully(): void
    {
        $suiteMock = new Suite();
        $suiteMock->id = 1;
        
        $data = ['amount_per_hour' => 150];

        // Lembre-se: O método update da service chama o método show() internamente primeiro
        // Então temos que mocar o show() para retornar a suíte, e DEPOIS mocar o update.
        $this->repositoryMock->shouldReceive('show')
            ->with(1)
            ->once()
            ->andReturn($suiteMock);

        $this->repositoryMock->shouldReceive('update')
            ->with($suiteMock, $data)
            ->once()
            ->andReturn($suiteMock);

        $result = $this->suiteService->update(1, $data);

        $this->assertInstanceOf(Suite::class, $result);
    }

    public function test_should_destroy_suite_successfully(): void
    {
        $suiteMock = new Suite();
        $suiteMock->id = 1;

        // O método destroy no Service também chama o show() antes para validar se existe
        $this->repositoryMock->shouldReceive('show')
            ->with(1)
            ->once()
            ->andReturn($suiteMock);

        $this->repositoryMock->shouldReceive('destroy')
            ->with(1)
            ->once()
            ->andReturn();

        // O método destroy tem payload void (não retorna nada), 
        // então se não travar e os mocks chamarem certinho, foi um sucesso.
        $this->suiteService->destroy(1);
        
        $this->assertTrue(true);
    }
}