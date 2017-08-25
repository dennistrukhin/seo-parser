<?php
namespace Dvt\Parser\LinksDetector\Mutator;

use Dvt\Parser\LinksDetector\MutatorInterface;

class AddHost implements MutatorInterface
{

    private $host;

    public function __construct(string $host)
    {
        $host = preg_replace('#https?:#', '', $host);
        $this->host = $host;
    }

    public function mutate(string $url): string
    {
        if (preg_match('#^/[^/]#', $url)) {
            $url = $this->host . $url;
        }
        return $url;
    }

}