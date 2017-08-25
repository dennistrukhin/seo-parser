<?php
namespace Dvt\Parser\LinksDetector\Mutator;

use Dvt\Parser\LinksDetector\MutatorInterface;

class RemoveProtocol implements MutatorInterface
{

    public function mutate(string $url): string
    {
        $url = preg_replace('#^https?:#', '', $url);
        return $url;
    }

}