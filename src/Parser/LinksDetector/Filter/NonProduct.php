<?php
namespace Dvt\Parser\LinksDetector\Filter;

use Dvt\Parser\LinksDetector\FilterInterface;

class NonProduct implements FilterInterface
{

    public function filter(string $url): bool
    {
        return strpos($url, '/product/') === false;
    }

}