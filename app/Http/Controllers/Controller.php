<?php

namespace App\Http\Controllers;

use App\Support\HttpStatus;
use App\Support\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Throwable;

class Controller extends BaseController
{
    public function __construct(Request $request)
    {
        $this->response = new Response();
        $this->request  = $request;
    }

    public function jsonResponse(): JsonResponse
    {
        return response()->json($this->response->getResponse(), $this->response->getStatus());
    }

    public function json($data, int $status = 200): JsonResponse
    {
        return response()->json($data, $status);
    }

    public function jsonException(Throwable $e, int $status = 500): JsonResponse
    {
        if( $e->getCode() > 0 ) {
            $status = $e->getCode();
        }

        if( !in_array($status, HttpStatus::getStatusList()) ) {
            $status = 500;
        }

        $this->response
            ->title("Ocorreu um erro inesperado")
            ->message($e->getMessage())
            ->icon("error")
            ->status($status);

        if(env("APP_DEBUG")) {
            $this->response->addData("file", $e->getFile())
                           ->addData("line", $e->getLine())
                           ->addData("trace", $e->getTrace());
        }

        return $this->jsonResponse();
    }
}
