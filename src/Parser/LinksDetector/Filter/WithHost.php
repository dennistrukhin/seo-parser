<?php
namespace Dvt\Parser\LinksDetector\Filter;

use Dvt\Parser\LinksDetector\FilterInterface;

class WithHost implements FilterInterface
{

    private $host = '';

    public function __construct(string $host)
    {
        $host = preg_replace('#https?:#', '', $host);
        $this->host = $host;
    }

    public function filter(string $url): bool
    {
        $regex = '#^(http:)?(https:)?' . $this->host . '#';
        return preg_match($regex, $url);
    }

}