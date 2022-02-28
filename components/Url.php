<?php

namespace app\components;

use Yii;
use yii\helpers\StringHelper;

/**
 * Helper methods when dealing with URLs and Links.
 *
 * Extends the {{yii\helpers\BaseUrl}} class by some usefull functions like:
 *
 * An example of create an URL based on Route in the UrlManager:
 *
 * ```php
 * Url::toRoute(['/module/controller/action']);
 * ```
 */
class Url extends \yii\helpers\BaseUrl
{
    /**
     * Add a trailing slash to an url if there is no trailing slash at the end of the url.
     *
     * @param string $url The url which a trailing slash should be appended
     * @param string $slash If you want to trail a file on a windows system it gives you the ability to add forward slashes.
     * @return string The url with added trailing slash, if requred.
     */
    public static function trailing($url, $slash = '/')
    {
        return rtrim($url, $slash) . $slash;
    }

    /**
     * Apply the http protcol to an url to make sure valid clickable links. Commonly used when provide link where user could have added urls
     * in an administration area. For Example:
     *
     * ```php
     * Url::ensureHttp('fastnet.am'); // return http://fastnet.am
     * Url::ensureHttp('www.fastnet.am'); // return https://fastnet.am
     * Url::ensureHttp('fastnet.am', true); // return https://fastnet.am
     * ```
     *
     * @param string $url The url where the http protcol should be applied to if missing
     * @param boolean $https Whether the ensured url should be returned as https or not.
     * @return string
     */
    public static function ensureHttp($url, $https = false)
    {
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = ($https ? "https://" : "http://") . $url;
        }

        return $url;
    }

    /**
     * Removes schema, protocol and www. subdomain from host.
     *
     * For example `https://fastnet.am/path` would return `fastnet.am/path`.
     *
     * @param string $url The url to extract
     * @return string returns the url without protocol or www. subdomain
     */
    public static function cleanHost($url)
    {
        return str_replace(['www.', 'http://', 'https://'], '', Url::ensureHttp($url));
    }
    /**
     * Return only the domain of a path.
     *
     * For example `https://fastnet.am/path` would return `fastnet.am` without path informations.
     *
     * @param string $url The url to extract
     * @return string Returns only the domain from the url.
     */
    public static function domain($url)
    {
        return self::cleanHost(parse_url(Url::ensureHttp($url), PHP_URL_HOST));
    }
}