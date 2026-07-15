<?php

class Sitemap
{
  private $links;
  private $links_state;
  private $domain;
  private $regex_domain;
  private $head;
  private $body;
  private $foot;
  private $default_proto;

  public function __construct($uri, $proto)
  {
    $this->head = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<urlset\n      xmlns=\"https://www.sitemaps.org/schemas/sitemap/0.9/\"\n      xmlns:xsi=\"https://www.w3.org/2001/XMLSchema-instance\"\n      xsi:schemaLocation=\"https://www.sitemaps.org/schemas/sitemap/0.9/\n            https://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">\n<!-- created with VisualTeam Sitemap Generator -->\n";
    $this->body = "";
    $this->foot = "</urlset>";

    $this->links = array($uri);
    $this->links_state = array(true);

    $this->domain = preg_replace('/\/$/', "", $uri);

    if ($proto !== 'http') {
      $this->default_proto = $proto;
      $proto_regex = '/^https?(.*)$/i';

      $this->domain = preg_replace($proto_regex, $proto.'$1', $this->domain);
      $this->links[0] = preg_replace($proto_regex, $proto.'$1', $this->links[0]);
    }

    $this->regex_domain = preg_quote($this->domain, '/');

    $this->iterating();
  }

  public function print($return = false)
  {
    if ($return) {
      return $this->head.$this->body.$this->foot;
    }

    echo $this->head.$this->body.$this->foot;

    return null;
  }

  private function iterating()
  {
    $i = 0;
    $has_new_links = true;

    while ($has_new_links) {
      if ($this->links_state[$i]) {
        $this->load_page($i);
        $this->links_state[$i] = false;
      }

      $has_new_links = false;

      foreach ($this->links_state as $state) {
        if ($state === true) {
          $has_new_links = true;
          break;
        }
      }

      $i++;
    }
  }

  private function load_page($index)
  {
    $uri = $this->links[$index];

    if (preg_match('/\.(jpe?g|png|gif|pdf|zip|rar|js|css)$/i', $uri)) {
      return;
    }

    $result = ESUtils::CurlGet($uri, true);

    $page = $result['DATA'];
    $status = $result['CODE'];

    if ($status === 301) {
      $uri = $this->href_clear($this->domain.$this->location($page));

      if (!in_array($uri, $this->links, true)) {
        array_push($this->links, $uri);
        array_push($this->links_state, true);
      }
    } elseif ($status !== 404) {
      if ($this->is_html($page)) {
        $this->body .= "<url>\n  <loc>".$uri."</loc>\n</url>\n";

        $this->parse_links($page);
      }
    }
  }

  private function parse_links($page)
  {
    if ($page === "") {
      return;
    }

    $i = 0;

    if (preg_match_all('/<a\s[^>]*href=([\"\']??)([^\" >]*?)\\1[^>]*>(.*)<\/a>/siU', $page, $matches)) {
      foreach ($matches[2] as $uri) {
        $uri = $this->href_clear($uri);

        if (!preg_match("/(mailto:|tel:|javascript:)/si", $uri)) {
          if ($uri[0] === '/') {
            $uri = $this->domain.$uri;
          }

          if ($uri !== "" &&
              !in_array($uri, $this->links, true) &&
              preg_match('/'.$this->regex_domain.'\//i', $uri) &&
              $uri !== $this->domain.'/'
          ) {
            array_push($this->links, $uri);
            array_push($this->links_state, true);
          }
        }

        $i++;
      }
    }
  }

  private function location($page)
  {
    $matches = array();
    preg_match('/Location: (?:'.$this->regex_domain.')?\/?(.*?)(?:\n|\s)/si', $page, $matches);
    return '/'.$matches[1];
  }

  private function title($page)
  {
    $matches = array();
    preg_match('/<title>(.*?)<\/title>/si', $page, $matches);
    return $matches[1];
  }

  private function is_html($page)
  {
    return preg_match('/Content-Type: text\/html/i', $page);
  }

  private function fix_uri($uri)
  {
    $uri = trim($uri);

    if ($uri[0] === '/' && $uri[1] && $uri[1] === '/') {
      $uri = $this->default_proto . ':'.$uri;
    }

    if ($uri[0] === '/' && $uri[1] && $uri[1] !== '/') {
      $uri = $this->domain.$uri;
    }

    if ($uri[0] !== 'h' && $uri[1] !== 't') {
      $uri = $this->domain.'/'.$uri;
    }

    if ($uri === $this->domain) {
      $uri .= '/';
    }

    $uri = preg_replace('/\/\//', '/', $uri);
    $uri = preg_replace('/http(s)?:\/([^\/])/', 'http$1://$2', $uri);

    return $uri;
  }

  private function href_clear($u)
  {
    return htmlspecialchars(preg_replace('/\#.*$/', "", str_replace('&amp;', '&', $this->fix_uri($u))));
  }
}

