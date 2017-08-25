<?php
namespace Dvt\Parser\LinksDetector\Filter;

use Dvt\Parser\LinksDetector\FilterInterface;

class NonEmpty implements FilterInterface
{

    public function filter(string $url): bool
    {
        return $url !== '';
    }

}