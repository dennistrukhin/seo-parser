<?php
namespace Dvt\Parser\LinksDetector;

interface FilterInterface
{

    public function valid(string $url);

}