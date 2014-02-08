<?php

namespace Kpacha\ReactiveSilex;

use React\Http\Request;
use React\Http\Response;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class ReactiveApplication extends Application
{

    public function __invoke(Request $request, Response $response)
    {
        $sfRequest = $this->buildSymfonyRequest($request, $response);
        $sfResponse = $this->getHandledResponse($sfRequest);
        $this->parseSymfonyResponse($response, $sfResponse);
    }

    private function buildSymfonyRequest(Request $request)
    {
        return SymfonyRequest::create($request->getPath(), $request->getMethod());
    }

    private function getHandledResponse(SymfonyRequest $sfRequest)
    {
        $sfResponse = null;
        try {
            $sfResponse = $this->handle($sfRequest, HttpKernelInterface::MASTER_REQUEST, false);
            $this->terminate($sfRequest, $sfResponse);
        } catch (\Exception $e) {
            $sfResponse = new SymfonyResponse('We are sorry, but something went terribly wrong.',
                    404 /* ignored */, array('X-Status-Code' => 200));
        }
        return $sfResponse;
    }

    private function parseSymfonyResponse(Response $response, SymfonyResponse $sfResponse)
    {
        $response->writeHead($sfResponse->getStatusCode(), $this->extractResponseHeaders($sfResponse));
        $response->end($sfResponse->getContent());
    }

    private function extractResponseHeaders(SymfonyResponse $sfResponse)
    {
        $headers = array();
        foreach ($sfResponse->headers->allPreserveCase() as $name => $values) {
            foreach ($values as $value) {
                $headers[$name] = $value;
            }
        }
        return $headers;
    }

}
