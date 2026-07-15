php-simple-html-dom-parser
==========================

Version 1.9.1

Updated version of https://github.com/sunra/php-simple-html-dom-parser/

Adaptation for Composer and PSR-0 of http://simplehtmldom.sourceforge.net/


Install
-------

 composer.phar
```json
"require": {
    "xbartes/php-simple-html-dom-parser": "1.9.1"
}
```

Usage
-----

```php
use Xbartes\PhpSimple\HtmlDomParser;

...
$dom = HtmlDomParser::str_get_html( $str );
or 
$dom = HtmlDomParser::file_get_html( $file_name );

$elems = $dom->find($elem_name);
...

```
