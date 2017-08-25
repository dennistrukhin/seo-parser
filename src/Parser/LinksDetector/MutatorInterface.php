<?php
namespace Dvt\Parser\LinksDetector;

interface MutatorInterface
{

    public function mutate(string $url): string;

}