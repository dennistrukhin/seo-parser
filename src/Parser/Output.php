<?php
namespace Dvt\Parser;

class Output
{

    private $fh;

    public function __construct($filePath)
    {
        $this->fh = fopen($filePath, 'w');
        fwrite($this->fh, 'sep=,' . PHP_EOL);
        fputcsv($this->fh, ['url', 'title', 'h1']);
    }

    public function add(string $url, SeoData $seoData)
    {
        fputcsv($this->fh, [$url, $seoData->getTitle(), $seoData->getH1()]);
    }

    public function flush(): void
    {
        fflush($this->fh);
    }

    public function __destruct()
    {
        fclose($this->fh);
    }

}