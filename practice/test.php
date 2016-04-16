<?php

require_once __DIR__.'/../vendor/autoload.php';

$urls = array(
	'https://yandex.ru',
	'https://ya.ru',
	'https://google.com'
);

$scanner = new \Agolomazov\Tools\Url\Scanner($urls);
print_r($scanner->getInvalidUrls());