<?php
namespace Dvt\Parser\LinksDetector;

interface FilterInterface
{

    public function filter(string $url): bool;

}