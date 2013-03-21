<?php

/**
 * translate file.
 */
include_once "translate.php";

/**
 * RSS search script
 * @author lukasz
 *
 */
class SearchRss
{
	/**
	 * get variables from submited form
	 * @var array
	 */
	public $get;
	
	/**
	 * url of rss
	 * @var string
	 */
	private $rss_url = "http://xlab.pl/feed/";
	
	/**
	 * array of result rss
	 * @var array
	 */
	public $rss_arr;
	
	/**
	 * result information of search
	 * @var string
	 */
	public $result;
	
	/**
	 * bool find option
	 * @var boolean
	 */
	public $found = false;

	/**
	 * action function
	 */
	public function action() {
		
		switch ($this->get[action]) {
			case "search_rss":
				$this->findRssWordByString($this->get[word], $this->get[action]);
			break;
			
			case "clear_rss":
				$this->clearRssWords();
			break;
			
			default:
				$this->findRssWordByString($this->get[word], $this->get[action]);
			break;
		}
	}
	
	/**
	 * find rss word by get keyword string
	 * @param array $get
	 * @return reult of searching $this->result
	 */
	public function findRssWordByString($getWord,$getAction){

		if($getAction=="search_rss" && (empty($getWord) || !$getWord)){
			return $this->error_msg("". LANG_ERR_EMPT_SEARCH_VAL_INP ."");
		}
		
		$getWord = $this->filterString($getWord);
		
		$content = $this->getRssUrlContent();
		$simple_xml = new SimpleXMLElement($content);

		foreach ($simple_xml->channel->item as $item)
		{
			$item->description = strtolower($item->description);
			if(preg_match('/([^a-z]|[^0-9]|^)'.$getWord.'([^a-z]|[^0-9]|$|(s[^a-z]|s[^0-9]))/',$item->description)){
			
				$this->found = true;
				$this->rss_arr[] = Array (
					'link'=>$item->link,
					'title'=>$item->title,
					'pubDate'=>substr($item->pubDate, 0, strpos($item->pubDate, "+"))
				);
			}
		}

		$this->result = ($this->found? LANG_RESULTS_FOUND : LANG_RESULTS_NOT_FOUND);
		return $this->result;
	}
	
	/**
	 * filter string
	 * @param string $getWord
	 * @return string $getWord
	 */
	private function filterString($getWord) {
		$getWord = strtolower($getWord);
		$getWord = strip_tags($getWord);
		$getWord = trim($getWord);
		$getWord = stripslashes($getWord);
		return $getWord;
	}
	
	/**
	 * get content of url from $this->rss_url
	 * @return content of url
	 */
	private function getRssUrlContent(){
		return file_get_contents($this->rss_url);
	}
	
	/**
	 * error message
	 * @param string $string_msg
	 * @return die message
	 */
	public function error_msg($string_msg){
		return die($string_msg);
	}
	
	public function clearRssWords(){
		unset($this->found, $this->result, $this->rss_arr);
		return header("Location: ./index.php");
	}
	
}

?>