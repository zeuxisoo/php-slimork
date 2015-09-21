<?php
namespace App\Helpers;

use Slim\Slim;

class Pagination {

    const VIEW_DEFAULT       = 0;
    const VIEW_PREVIOUS_NEXT = 1;

    public $total_records = 0;
    public $current_page  = 1;
    public $per_page      = 18;
    public $total_page    = 0;
    public $offset        = 0;
    public $keyword       = 'page';

    private $website_url   = null;
    private $query_strings = array();

    public function __construct($total_records = 0, $per_page = 20, $keyword = 'page') {
        $this->parseQueryString();

        $this->keyword       = $keyword;
        $this->per_page      = abs($per_page);
        $this->total_records = abs($total_records);

        $this->total_page    = ceil($this->total_records / $this->per_page);
        $this->total_page    = $this->total_page <= 0 ? 1 : $this->total_page;
        $this->current_page  = isset($_GET[$this->keyword]) ? abs(intval($_GET[$this->keyword])) : 0;
        $this->current_page  = $this->current_page == 0 ? 1 : $this->current_page;
        $this->current_page  = $this->current_page > $this->total_page ? $this->total_page : $this->current_page;
        $this->offset        = ($this->current_page - 1) * $this->per_page;
    }

    private function getUrl($param, $value) {
        $query_strings = $this->query_strings;
        $query_strings[$param] = $value;

        return $this->website_url.'?'.http_build_query($query_strings);
    }

    private function parseQueryString() {
        if (isset($_SERVER['SCRIPT_URI'])) {
            $script_uri = $_SERVER['SCRIPT_URI'];
        }else{
            $script_uri = $_SERVER['REQUEST_URI'];
        }

        $query_position = strpos($script_uri, '?');

        if ($query_position > 0) {
            $query_string = substr($script_uri, $query_position + 1);

            // String to String[key] = value
            parse_str($query_string, $query_strings);

            $website_url = substr($script_uri, 0, $query_position);
        } else {
            $website_url   = $script_uri;
            $query_strings = array();
        }

        $this->query_strings = empty($query_strings) === true ? array() : $query_strings;
        $this->website_url   = $website_url;
    }

    /*
     * $options:
     *  - view: VIEW_DEFAULT | TYPE_NEXT_BACK
     */
    public function buildPageBar($options = array()) {
        $options = array_merge(array(
            'view' => static::VIEW_DEFAULT,
        ), $options);

        $app          = Slim::getInstance();
        $current_page = $this->current_page;
        $total_page   = $this->total_page;
        $page_view    = "";

        switch($options['view']) {
            case static::VIEW_DEFAULT:
                if ($this->total_page <= 7) {
                    $range = range(1, $total_page);
                } else {
                    $min = $current_page - 3;
                    $max = $current_page + 3;

                    if ($min < 1) {
                        $max += (3 - $min);
                        $min  = 1;
                    }

                    if ($max > $total_page) {
                        $min -= $max - $total_page;
                        $max  = $total_page;
                    }

                    $min = $min > 1 ? $min : 1;
                    $range = range($min, $max);
                }

                $pages = array();
                foreach($range AS $one) {
                    $pages[$one] = $this->getUrl($this->keyword, $one);
                }

                $urls = array(
                    'first'    => $this->getUrl($this->keyword, 1),
                    'previous' => $this->getUrl($this->keyword, $current_page - 1),
                    'pages'    => $pages,
                    'next'     => $this->getUrl($this->keyword, $current_page + 1),
                    'last'     => $this->getUrl($this->keyword, $total_page)
                );

                $page_view = $app->render('pagination/default.html', compact('urls', 'current_page', 'total_page'));
                break;
            case static::VIEW_PREVIOUS_NEXT:
                $urls = array(
                    'previous' => $this->getUrl($this->keyword, $current_page - 1),
                    'next'     => $this->getUrl($this->keyword, $current_page + 1)
                );

                $page_view = $app->render('pagination/previous-next.html', compact('urls', 'current_page', 'total_page'));
                break;
        }

        return $page_view;
    }
}
