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
        } catch (RequestException $e) {
            echo 'Request to ' . $e->getRequest()->getUri()->getScheme() . '://' . $e->getRequest()->getUri()->getHost() . $e->getRequest()->getUri()->getPath() . ' failed: '
            . $e->getMessage();
            $html = '';
            $code = 0;
        }
        return new Page($url, $code, $html);
    }

}