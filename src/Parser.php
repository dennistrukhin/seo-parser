<?php
namespace Dvt;

use Dvt\Parser\LinksDetector;
use Dvt\Parser\PageRetriever;
use Dvt\Parser\SeoDataDetector;
use GuzzleHttp\Client;

class Parser
{

    private $host;
    private $visitedUrls = [];
    private $entryUrl = '/';
    /** @var PageRetriever $pageRetriever */
    private $pageRetriever;
    /** @var SeoDataDetector $seoDetector */
    private $seoDetector;
    /** @var LinksDetector $linksDetector */
    private $linksDetector;

    public function __construct($host)
    {
        $this->host = $host;
        $client = new Client([
            'base_uri' => $this->host,
        ]);
        $this->pageRetriever = new PageRetriever($client);
        $this->seoDetector = new SeoDataDetector();
        $this->linksDetector = new LinksDetector();
        $this->linksDetector->addMutator(new LinksDetector\Mutator\StripHashAndParameters());
        $this->linksDetector->addMutator(new LinksDetector\Mutator\RemoveProtocol());
        $this->linksDetector->addMutator(new LinksDetector\Mutator\AddHost($this->host));
    }

    /**
     * @param string $entryUrl
     */
    public function setEntryUrl(string $entryUrl)
    {
        $this->entryUrl = $entryUrl;
    }

    public function run()
    {
        $this->iterate([$this->entryUrl]);
    }

    private function iterate(array $urls)
    {
        foreach ($urls as $url) {
            $page = $this->pageRetriever->get($url);
            $seoData = $this->seoDetector->get($page);
            $links = $this->linksDetector->get($page);
            var_dump($links);
        }
    }

}