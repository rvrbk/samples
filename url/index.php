<?php

include('url.php');
include('unit.php');

use Utils\Url;
use Test\Unit;

$address = 'http://www.connecting.nl/dot?connecting=dots&amp;where=everywhere#spot';

$url = new Url($address);

echo Unit::assert('http://www.connecting.nl/dot?connecting=dots&where=everywhere#spot', $url->url);
echo Unit::assert('http', $url->scheme);
echo Unit::assert('www.connectingthedots.nl', $url->host);
echo Unit::assert('dot', $url->path);
echo Unit::assert('connecting=dots&where=everywhere', $url->query);
echo Unit::assert('spot', $url->fragment);

?>