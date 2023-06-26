<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SnifferController extends Controller
{
    //
    public static function sinff_title($dom)
    {
        // Get Movie Title
        $h1Elements = $dom->getElementsByTagName('h1');
        foreach ($h1Elements as $h1) {
            $itemprop = $h1->getAttribute('itemprop');
            if ($itemprop === 'name') {
                return $h1->nodeValue;
            }
        }

        return null;
    }

    public static function sniff_imdb($dom)
    {
        // Get IMDB ID
        $xpath = new \DOMXPath($dom);

        // Find the parent div element with class name "imdb"
        $parentDiv = $xpath->query('//div[contains(@class, "imdb_r")]')->item(0);

        if ($parentDiv) {
            // Get the href values of child <a> tags
            $childAnchors = $xpath->query('.//a', $parentDiv);

            foreach ($childAnchors as $anchor) {
                $href = $anchor->getAttribute('href');
                if (str_starts_with($href, 'https://www.imdb.com/title/')) {
                    $string = explode('/title/', $href);
                    $id = str_replace("/", '', $string[1]);
                    return $id;
                }
            }

            return null;
        }
    }

    public static function sniff_description($dom)
    {
        $description = "";
        // Get Movie Description
        $parentDiv = $dom->getElementById('cap1');
        if (!is_null($parentDiv)) {
            $pTags = $parentDiv->getElementsByTagName('p');
            foreach ($pTags as $p) {
                $description .= $p->nodeValue;
            }
        }

        // description trim
        $description = str_replace("\n", "", $description);

        return $description;
    }

    public static function sniff_urls($dom)
    {

        $result = [];

        $xpath = new \DOMXPath($dom);

        // Find the parent div element with class name "enlaces_box"
        $parentDiv = $xpath->query('//div[contains(@class, "enlaces_box")]')->item(0);

        if ($parentDiv) {
            // Get the href values of child <a> tags
            $childAnchors = $xpath->query('.//a', $parentDiv);

            foreach ($childAnchors as $anchor) {
                $href = $anchor->getAttribute('href');

                // Megaup
                if (str_starts_with($href, 'https://megaup.net')) {
                    array_push($result, $href);
                }

                // Meganz
                if (str_starts_with($href, 'https://mega.nz')) {
                    array_push($result, $href);
                }
                // Yoteshin
                if (str_starts_with($href, 'https://yoteshinportal.cc')) {
                    array_push($result, $href);
                }
            }
        }

        return $result;
    }

    public static function sniff_poster($dom)
    {
        $xpath = new \DOMXPath($dom);

        // Find the <img> tag with itemprop="image"
        $imageTag = $xpath->query('//img[@itemprop="image"]')->item(0);

        if ($imageTag) {
            $src = $imageTag->getAttribute('src');
            return $src;
        }

        return "";
    }
}