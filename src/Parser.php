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
            'verify' => false,
        ]);
        $this->pageRetriever = new PageRetriever($client);
        $this->seoDetector = new SeoDataDetector();
        $this->linksDetector = new LinksDetector();
        $this->linksDetector->addMutator(new LinksDetector\Mutator\StripHashAndParameters());
        $this->linksDetector->addMutator(new LinksDetector\Mutator\RemoveProtocol());
        $this->linksDetector->addMutator(new LinksDetector\Mutator\AddHost($this->host));
        $this->linksDetector->addFilter(new LinksDetector\Filter\NonEmpty());
        $this->linksDetector->addFilter(new LinksDetector\Filter\WithHost($this->host));
        $this->linksDetector->addFilter(new LinksDetector\Filter\NonProduct());
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
            echo $page->getCode() . ' ' . $url . PHP_EOL;
            if ($page->getCode() === 200) {
                $seoData = $this->seoDetector->get($page);
                $this->visitedUrls[$url] = $seoData;
                $links = $this->linksDetector->get($page);
                $linksToVisit = [];
                foreach ($links as $link) {
                    if (!isset($this->visitedUrls[$link])) {
                        $linksToVisit[] = $link;
                    }
                }
                if (count($linksToVisit) > 0) {
                    $this->iterate($linksToVisit);
                }
            }
        }
    }

}