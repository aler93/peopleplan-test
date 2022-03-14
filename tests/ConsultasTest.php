<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ConsultasTest extends TestCase
{
    private string $cliente    = "36392436847";
    private string $clientCode;
    private string $clientKey;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->clientCode = env("CLIENT_CODE");
        $this->clientKey = env("CLIENT_KEY");
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testVendas()
    {
        $this->json("GET", '/api/vendas')->assertResponseOk();
    }

    public function testCliente()
    {
        $this->json("GET", '/api/cliente/' . $this->cliente)->assertResponseOk();
    }

    public function testParcelas()
    {
        $this->json("GET", '/api/parcelas/' . $this->clientCode . '/' . $this->clientKey)->assertResponseOk();
    }
}
