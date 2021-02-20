<?php

namespace Utils;

class Url 
{
    private $url = null;
    private $scheme = null;
    private $host = null;
    private $path = null;
    private $query = null;
    private $fragment = null;

    static private $map = [
        'url' => '/^([[:graph:]]+)/',
        'scheme' => '/^([a-zA-Z]+)\:/',
        'host' => '/:\/\/([^\/]+).*/',
        'port' => '/:([\d]+)/',
        'path' => '/.[a-z]\/([\da-zA-Z]+)\??/',
        'query' => '/\?([a-zA-Z={1,}&{0,}]+)/',
        'fragment' => '/\#([[:graph:]]+)$/'
    ];

    public function __construct($url) 
    {
        $url = html_entity_decode($url);

        foreach(get_object_vars($this) as $property => $value) {
            if(preg_match(self::$map[$property], $url, $matches)) {
                $this->$property = $matches[1];
            }    
        }
    }

    public function __get($property) 
    {
        return $this->$property;
    }

    public function __toString()
    {
        return $this->url;
    }
}

?>