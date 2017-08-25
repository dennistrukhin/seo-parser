<?php
namespace Dvt\Parser;

class SeoDataDetector
{

    /**
     * @param Page $page
     * @return SeoData
     */
    public function get(Page $page): SeoData
    {
        $html = $page->getHtml();
        $h1 = null;
        $title = null;
        if (preg_match('#<h1[^>]*>(.*?)</h1>#', $html, $matches)) {
            $h1 = $matches[1];
        }
        if (preg_match('#<title[^>]*>(.*?)</title>#', $html, $matches)) {
            $title = $matches[1];
        }
        $seoData = new SeoData($title, $h1);
        return $seoData;
    }

}