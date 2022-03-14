<?php

namespace App\Http\Controllers;

//use GuzzleHttp\Client;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class VendasController extends Controller
{
    public function Vendas(Request $request): JsonResponse
    {
        try {
            $perPage = $request->input("perPage") ?? 5;
            $page    = $request->input("page") ?? 0;
            $query   = ["page" => $page, "per_page" => $perPage];

            $client = new Client(['base_uri' => env("FPAY")]);
            $res    = $client->request("GET", "/vendas", ["query" => $query]);

            if( $res->getStatusCode() != 200 ) {
                throw new Exception("Ocorreu um erro inesperado", $res->getStatusCode());
            }
            $vendas = json_decode($res->getBody()->getContents());

            return $this->json($vendas);
        } catch( Exception | GuzzleException $e ) {
            return $this->jsonException($e);
        }
    }

    // TODO

    /**
     * @param string $documento
     * @return JsonResponse
     */
    public function Cliente(string $documento): JsonResponse
    {
        try {
            $query = ["nu_documento" => $documento];

            $client = new Client(['base_uri' => env("FPAY"), "query" => $query]);
            $res = $client->get("/clientes", [
                "headers" => [
                    "Content-Type" => "application/json",
                    "Client-Code"  => env("CLIENT_CODE"),
                    "Client-key"   => env("CLIENT_KEY"),
                ]
            ]);

            $cliente = json_decode($res->getBody()->getContents());

            return $this->json($cliente);
        } catch( Exception | GuzzleException $e ) {
            return $this->jsonException($e);
        }
    }

    /**
     * @param string $code
     * @param string $key
     * @return JsonResponse
     */
    public function Parcelas(string $code, string $key): JsonResponse
    {
        try {
            $client = new Client(['base_uri' => env("FPAY")]);
            $res    = $client->request("GET", "/parcelas", [
                "Content-Type" => "application/json",
                "Client-Code"  => $code,
                "Client-key"   => $key
            ]);

            if( $res->getStatusCode() != 200 ) {
                throw new Exception("Ocorreu um erro inesperado", $res->getStatusCode());
            }
            $parcelas = json_decode($res->getBody()->getContents());

            return $this->json($parcelas);
        } catch( Exception | GuzzleException $e ) {
            return $this->jsonException($e);
        }
    }
}
