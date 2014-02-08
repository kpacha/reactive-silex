<?php

namespace Kpacha\ReactiveSilex;

use React\Http\Request;
use React\Http\Response;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ReactiveApplication extends Application
{

    public function react(Request $request, Response $response, $requestData = '')
    {
        $sfRequest = $this->buildSymfonyRequest($request, $requestData);
        $sfResponse = $this->getHandledResponse($sfRequest);
        $this->parseSymfonyResponse($response, $sfResponse);
    }

    private function buildSymfonyRequest(Request $request, $requestData = '')
    {
        $params = $this->extractRequestParameters($requestData);
        return SymfonyRequest::create($request->getPath(), $request->getMethod(), $params);
    }

    private function extractRequestParameters($requestData = '')
    {
        $params = array();
        if ($requestData) {
            $rawParams = explode('&', $requestData);
            foreach($rawParams as $rawParam){
                $receivedParam = explode('=', $rawParam);
                $params[urldecode($receivedParam[0])] = urldecode($receivedParam[1]);
            }
        }
        return $params;
    }

    private function getHandledResponse(SymfonyRequest $sfRequest)
    {
        $sfResponse = null;
        try {
            $sfResponse = $this->handle($sfRequest, HttpKernelInterface::MASTER_REQUEST, false);
            $this->terminate($sfRequest, $sfResponse);
        } catch(NotFoundHttpException $e){
            $sfResponse = new SymfonyResponse('Ups! ' . $e->getMessage(), 404);
        } catch (\Exception $e) {
            $sfResponse = new SymfonyResponse('We are sorry, but something went terribly wrong. ', 500);
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
