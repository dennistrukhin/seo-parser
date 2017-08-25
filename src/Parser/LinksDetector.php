<?php
namespace Dvt\Parser;

use Dvt\Parser\LinksDetector\FilterInterface;
use Dvt\Parser\LinksDetector\MutatorInterface;

class LinksDetector
{

    /** @var MutatorInterface[] $mutators */
    private $mutators = [];
    /** @var FilterInterface[] $filters */
    private $filters = [];

    public function addFilter(FilterInterface $filter)
    {
        $this->filters[] = $filter;
    }

    public function addMutator(MutatorInterface $mutator)
    {
        $this->mutators[] = $mutator;
    }

    public function get(Page $page): array
    {
        $links = [];
        $html = $page->getHtml();
        if (preg_match_all('#<a[^>]*href=[\'"](.*?)[\'"][^>]*>#', $html, $matches)) {
            $candidates = $matches[1];
            $candidates = array_map(function (string $url) {
                foreach ($this->mutators as $mutator) {
                    $url = $mutator->mutate($url);
                }
                return $url;
            }, $candidates);
            $candidates = array_unique($candidates);

            $links = $candidates;
        }

        return $links;
    }

}