<?php
namespace Dvt\Parser;

class Page
{

    private $url;
    private $code;
    private $html;

    public function __construct(?string $url = null, int $code = 200, ?string $html = null)
    {
        $this->url = $url;
        $this->code = $code;
        $this->html = $html;
    }

    /**
     * @return null|string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param null|string $url
     */
    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param int $code
     */
    public function setCode(int $code)
    {
        $this->code = $code;
    }

    /**
     * @return string|null
     */
    public function getHtml(): ?string
    {
        return $this->html;
    }

    /**
     * @param string|null $html
     */
    public function setHtml(?string $html): void
    {
        $this->html = $html;
    }

}