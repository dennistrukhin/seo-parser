<?php
namespace Dvt\Parser;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;

class PageRetriever
{

    /** @var Client $client */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $url
     * @return Page
     */
    public function get(string $url): Page
    {
        try {
            $response = $this->client->get($url);
            $code = $response->getStatusCode();
            $html = $response->getBody()->getContents();
        } catch (ClientException | ServerException $e) {
            $code = $e->getResponse()->getStatusCode();
            $html = '';
        }
        return new Page($url, $code, $html);
    }

}