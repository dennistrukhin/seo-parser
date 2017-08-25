<?php
namespace Dvt\Parser;

class SeoData
{

    private $title;
    private $h1;

    public function __construct(?string $title = null, ?string $h1 = null)
    {
        $this->title = $title;
        $this->h1 = $h1;
    }

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param null|string $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return null|string
     */
    public function getH1(): ?string
    {
        return $this->h1;
    }

    /**
     * @param null|string $h1
     */
    public function setH1(?string $h1): void
    {
        $this->h1 = $h1;
    }



}