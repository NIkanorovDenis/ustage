<?php

namespace Xbartes\PhpSimple;

require __DIR__ . DIRECTORY_SEPARATOR . 'simplehtmldom' . DIRECTORY_SEPARATOR . 'simple_html_dom.php';

class HtmlDomParser {
	
	/**
	 * @return \simple_html_dom
	 */
	static public function file_get_html() {
		return call_user_func_array ( '\file_get_html' , func_get_args() );
	}

	/**
	 * get html dom from string
	 * @return \simple_html_dom
	 */
	static public function str_get_html() {
		return call_user_func_array ( '\str_get_html' , func_get_args() );
	}
}