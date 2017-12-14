<?php
namespace App\Http\Requests;
	
class ApiGetRequest
{
    /**
     * @var array
     */
    private $parameters = [];

    /**
     * @var
     */
    private $query_string;

    /**
     * ApiRequest constructor.
     */
    public function __construct() {
		$this->setQueryString();
		$this->fillParameters();
	}

    /**
     * @return string
     */
    private function getQueryString() : string {
		return $this->query_string;
	}

    /**
     * Set query string
     */
    private function setQueryString() {
		$this->query_string = (isset($_SERVER['QUERY_STRING'])) ? urldecode($_SERVER['QUERY_STRING']) : "";
	}

    /**
     * Prepare query string parameters
     */
    private function fillParameters() {
		if(($query_string = $this->getQueryString()) === ""){
			return;
		}

		// Traverse all query string chunks splited by "&"
        // And bind parameters to request object
		foreach(explode("&", $query_string) as $parameter) {
			
			$splited_parameter = preg_split('/[=\s]+/', $parameter, 2);

			if(count($splited_parameter) < 2){
				return;
			}

			if($splited_parameter[0] == "" || $splited_parameter[1] == ""){
				return;
			}

			$this->parameters[trim($splited_parameter[0])] = trim($splited_parameter[1]);		
		}
	}

    /**
     * Get all parameters
     *
     * @return array
     */
    public function all() : array {
		return $this->parameters;
	}

    /**
     * @param $key
     * @return string
     */
    public function __get($key) : string {
		if(!isset($this->all()[$key])){
			return null;
		}
		
		return $this->parameters[$key];
	}
}	