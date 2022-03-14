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
    // TODO: Adicionar JSON de resposta
    /**
     * @OA\Get(
     *     path="/api/vendas",
     *     operationId="/sample/category/things",
     *     tags={"Consulta"},
     *     @OA\Response(
     *         response="200",
     *         description="Lista de vendas",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Error: Erro interno no servidor.",
     *     ),
     * )
     */
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

    // TODO: Adicionar JSON de resposta
    /**
     * @OA\Get(
     *     path="/api/cliente",
     *     operationId="/sample/category/things",
     *     tags={"Consulta"},
     *     @OA\Response(
     *         response="200",
     *         description="Dados do cliente",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Parameter(
     *         name="documento",
     *         in="path",
     *         description="Número do documento do cliente para efetuar busca",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Error: Erro interno no servidor.",
     *     ),
     * )
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

            if( $res->getStatusCode() != 200 ) {
                throw new Exception("Ocorreu um erro inesperado", $res->getStatusCode());
            }

            $cliente = json_decode($res->getBody()->getContents());

            return $this->json($cliente);
        } catch( Exception | GuzzleException $e ) {
            return $this->jsonException($e);
        }
    }

    // TODO: Adicionar JSON de resposta
    /**
     * @OA\Get(
     *     path="/api/parcelas",
     *     operationId="/sample/category/things",
     *     tags={"Consulta"},
     *     @OA\Response(
     *         response="200",
     *         description="Dados do cliente",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Parameter(
     *         name="code",
     *         in="path",
     *         description="Número do code para efetuar busca",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="Número da key para efetuar busca",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Error: Erro interno no servidor.",
     *     ),
     * )
     */
    public function Parcelas(string $code, string $key): JsonResponse
    {
        try {
            $client = new Client(['base_uri' => env("FPAY")]);
            $res    = $client->request("GET", "/parcelas", [
                "headers" => [
                    "Content-Type" => "application/json",
                    "Client-Code"  => $code,
                    "Client-key"   => $key
                ]
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
