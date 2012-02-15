<?php
if (defined("IN_APPS") === false) exit("Access Dead");

class Paginate {

	public $row_count	= 0;
	public $page_no		= 1;
	public $page_size	= 18;
	public $page_count	= 0;
	public $offset		= 0;
	public $page_string = 'page';

	private $script = null;
	private $value_array = array();

	public function __construct($count = 0, $size = 20, $string = 'page') {
		$this->default_query();
		$this->page_string = $string;
		$this->page_size = abs($size);
		$this->row_count = abs($count);

		$this->page_count = ceil($this->row_count / $this->page_size);
		$this->page_count = $this->page_count <= 0 ? 1 : $this->page_count;
		$this->page_no = isset($_GET[$this->page_string]) ? abs(intval($_GET[$this->page_string])) : 0;
		$this->page_no = $this->page_no == 0 ? 1 : $this->page_no;
		$this->page_no = $this->page_no > $this->page_count ? $this->page_count : $this->page_no;
		$this->offset = ($this->page_no - 1) * $this->page_size;
	}

	private function get_url($param, $value) {
		$value_array = $this->value_array;
		$value_array[$param] = $value;
		return $this->script . '?' . http_build_query($value_array);
	}

	private function default_query() {
		if (isset($_SERVER['SCRIPT_URI'])) {
			$script_uri = $_SERVER['SCRIPT_URI'];
		}else{
			$script_uri = $_SERVER['REQUEST_URI'];
		}

		$query_position = strpos($script_uri,'?');

		if ($query_position > 0) {
			$qstring = substr($script_uri, $query_position + 1);
			parse_str($qstring, $value_array);
			$script = substr($script_uri, 0, $query_position);
		} else {
			$script = $script_uri;
			$value_array = array();
		}
		$this->value_array = empty($value_array) === true ? array() : $value_array;
		$this->script = $script;
	}

	public function calculate_page_data($switch=1){
		$from = $this->page_size * ($this->page_no-1) + 1;
		$from = $from > $this->row_count ? $this->row_count : $from;
		$to = $this->page_no * $this->page_size;
		$to = $to > $this->row_count ? $this->row_count : $to;
		$size = $this->page_size;
		$no = $this->page_no;
		$max = $this->page_count;
		$total = $this->row_count;

		return array(
			'offset' => $this->offset,
			'from' => $from,
			'to' => $to,
			'size' => $size,
			'no' => $no,
			'max' => $max,
			'total' => $total,
		);
	}

	public function build_page_bar() {
		$r = $this->calculate_page_data();
		$buffer = null;
		$index = '&laquo;';
		$pre = '&lsaquo;';
		$next = '&rsaquo;';
		$end = '&raquo;';

		if ($this->page_count <= 7) {
			$range = range(1, $this->page_count);
		} else {
			$min = $this->page_no - 3;
			$max = $this->page_no + 3;

			if ($min < 1) {
				$max += (3-$min);
				$min = 1;
			}

			if ( $max > $this->page_count ) {
				$min -= $max - $this->page_count;
				$max = $this->page_count;
			}

			$min = $min > 1 ? $min : 1;
			$range = range($min, $max);
		}

		$buffer .= '<div class="pagination">';
		$buffer .= '<ul>';

		if ($this->page_no > 1) {
			$buffer .= "<li><a href='".$this->get_url($this->page_string, 1)."'>{$index}</a></li>";
			$buffer .=" <li><a href='".$this->get_url($this->page_string, $this->page_no-1)."'>{$pre}</a></li>";
		}

		foreach($range AS $one) {
			if ( $one == $this->page_no ) {
				$buffer .= "<li class=\"active\"><a href='".$this->get_url($this->page_string, $one)."'>{$one}</a></li>";
			} else {
				$buffer .= "<li><a href='".$this->get_url($this->page_string, $one)."'>{$one}</a></li>";
			}
		}

		if ($this->page_no < $this->page_count) {
			$buffer .= "<li><a href='".$this->get_url($this->page_string, $this->page_no+1)."'>{$next}</a></li>";
			$buffer .= "<li><a href='".$this->get_url($this->page_string, $this->page_count)."'>{$end}</a></li>";
		}

		return $buffer . '</ul></div>';

	}
}
?>
