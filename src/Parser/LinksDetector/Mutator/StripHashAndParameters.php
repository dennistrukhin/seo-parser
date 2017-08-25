<?php
namespace Dvt\Parser\LinksDetector\Mutator;

use Dvt\Parser\LinksDetector\MutatorInterface;

class StripHashAndParameters implements MutatorInterface
{

    public function mutate(string $url): string
    {
        $parts = preg_split('/(\?|#)/', $url);
        return $parts[0];
    }

}