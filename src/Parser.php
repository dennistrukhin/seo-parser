<?php
namespace Dvt;

use Dvt\Parser\LinksDetector;
use Dvt\Parser\Output;
use Dvt\Parser\Page;
use Dvt\Parser\PageRetriever;
use Dvt\Parser\SeoDataDetector;
use GuzzleHttp\Client;

class Parser
{

    private $host;
    private $visitedUrls = [];
    private $entryUrl = '//www.velosite.ru/';
    /** @var PageRetriever $pageRetriever */
    private $pageRetriever;
    /** @var SeoDataDetector $seoDetector */
    private $seoDetector;
    /** @var LinksDetector $linksDetector */
    private $linksDetector;
    /** @var Output $output */
    private $output;

    public function __construct($host)
    {
        $this->host = $host;
        $client = new Client([
            'base_uri' => $this->host,
            'verify' => false,
        ]);
        $this->pageRetriever = new PageRetriever($client);
        $this->seoDetector = new SeoDataDetector();
        $this->output = new Output('D:\seo.csv');
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
        $linksToVisit = [];
        /** @var Page[] $pages */
        $pages = [];
        foreach ($urls as $url) {
            $this->visitedUrls[$url] = true;
            $page = $this->pageRetriever->get($url);
            $pages[] = $page;
            echo $page->getCode() . ' ' . $url . PHP_EOL;
        }
        foreach ($pages as $page) {
            if ($page->getCode() === 200) {
                $seoData = $this->seoDetector->get($page);
                $this->output->add($page->getUrl(), $seoData);
                $links = $this->linksDetector->get($page);
                foreach ($links as $link) {
                    if (!isset($this->visitedUrls[$link])) {
                        $linksToVisit[] = $link;
                    }
                }
            }
        }
        if (count($linksToVisit) > 0) {
            echo PHP_EOL, "Parsing links from ", implode(', ', $urls), PHP_EOL;
            $linksToVisit = array_values(array_unique($linksToVisit));
            $this->iterate($linksToVisit);
        }
    }

}