<?php
class EtherpadLiteClient {

	const API_VERSION						 = '1.2.9';

	const CODE_OK								 = 0;
	const CODE_INVALID_PARAMETERS = 1;
	const CODE_INTERNAL_ERROR		 = 2;
	const CODE_INVALID_FUNCTION	 = 3;
	const CODE_INVALID_API_KEY		= 4;

	protected $api_key = "";
	protected $url = "http://localhost:9001/api";
	
	public function __construct($api_key, $url = 'http://localhost:9001/api'){
		if (strlen($api_key) < 1){
			throw new InvalidArgumentException("[{$api_key}] is not a valid API key");
		}
		$this->apiKey	= $api_key;

		if (isset($url)){
			$this->url = $url;
		}
		if (!filter_var($this->url, FILTER_VALIDATE_URL)){
			throw new InvalidArgumentException("[{$this->url}] is not a valid URL");
		}
	}
	
	protected function get($function, array $arguments = array()){
		return $this->call($function, $arguments, 'GET');
	}
	
	protected function post($function, array $arguments = array()){
		return $this->call($function, $arguments, 'POST');
	}
	
	protected function call($function, array $arguments = array(), $method = 'POST'){
		$arguments['apikey'] = $this->apiKey;
		$arguments = http_build_query($arguments, '', '&');
		$url = $this->url."/".self::API_VERSION."/".$function;
		if ($method !== 'POST') { $url .=	"?".$arguments; }
		// use curl of it's available
		if (function_exists('curl_init')){
			$c = curl_init($url);
			curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($c, CURLOPT_TIMEOUT, 20);
			if ($method === 'POST'){
				curl_setopt($c, CURLOPT_POST, true);
				curl_setopt($c, CURLOPT_POSTFIELDS, $arguments);
			}
			$result = curl_exec($c);
			curl_close($c);
		// fallback to plain php
		} else {
			$params = array('http' => array('method' => $method, 'ignore_errors' => true, 'header' => 'Content-Type:application/x-www-form-urlencoded'));
			if ($method === 'POST'){
				$params['http']['content'] = $arguments;
			}
			$context = stream_context_create($params);
			$fp = fopen($url, 'rb', false, $context);
			$result = $fp ? stream_get_contents($fp) : null;
		}
		
		if(!$result){ throw new UnexpectedValueException("Empty or No Response from the server"); }
		
		$result = json_decode($result);
		if ($result === null){ throw new UnexpectedValueException("JSON response could not be decoded"); }
		//return $this->handleResult($result);
		return $result;
	}


	protected function handleResult($result){
		if (!isset($result->code)){ throw new RuntimeException("API response has no code"); }
		if (!isset($result->message)){ throw new RuntimeException("API response has no message"); }
		if (!isset($result->data)){ $result->data = null; }
		switch ($result->code){
			case self::CODE_OK:
				return $result->data;
			case self::CODE_INVALID_PARAMETERS:
			case self::CODE_INVALID_API_KEY:
				throw new InvalidArgumentException($result->message);
			case self::CODE_INTERNAL_ERROR:
				throw new RuntimeException($result->message);
			case self::CODE_INVALID_FUNCTION:
				throw new BadFunctionCallException($result->message);
			default:
				throw new RuntimeException("An unexpected error occurred whilst handling the response");
		}
	}
	
	/**
	 * @param $method
	 * @param array $args
	 * @return Response
	 * @throws Exception\UnsupportedMethodException
	 */
	public function __call($method, $args = array()) {
		if (!in_array($method, array_keys(self::getMethods()))) { throw new UnsupportedMethodException(); }
		$args = self::getParams($method, $args);
		// Important : don't use GET because it doesn't handle well html content...
		return $this->post($method, $args);
	}

	/**
	 * Generates a random padID
	 *
	 * @return string
	 */
	public function generatePadID() {
		$chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
		$length = 16;
		$padID = "";
		for ($i = 0; $i < $length; $i++) {
			$padID .= $chars[rand()%strlen($chars)];
		}
		return $padID;
	}

	/**
	 * Maps the given arguments from Client::__call to the parameter of the api method
	 *
	 * @return array
	 */
	public function getParams($method, $args) {
		$params = array();
		$methods = self::getMethods();
		foreach ($methods[$method] as $key => $paramName) {
			if (isset($args[$key])) {
				$params[$paramName] = $args[$key];
			}
		}
		return $params;
	}

	/**
	 * Array that holds the available methods and their required parameter names
	 *
	 * @return array
	 */
	public static function getMethods() {
		return array(
			// GROUPS
			// Pads can belong to a group. There will always be public pads that doesnt belong to a group (or we give this group the id 0)
			'createGroup' => array(),
			'createGroupIfNotExistsFor' => array('groupMapper'),
			'deleteGroup' => array('groupID'),
			'listPads' => array('groupID'),
			'createGroupPad' => array('groupID', 'padName', 'text'),
			'listAllGroups' => array(),
			
			// AUTHOR
			// Theses authors are bind to the attributes the users choose (color and name).
			'createAuthor' => array('name'),
			'createAuthorIfNotExistsFor' => array('authorMapper', 'name'),
			'listPadsOfAuthor' => array('authorID'),
			'getAuthorName' => array('authorID'),
			
			// SESSION
			// Sessions can be created between a group and a author. This allows
			// an author to access more than one group. The sessionID will be set as
			// a cookie to the client and is valid until a certian date.
			'createSession' => array('groupID', 'authorID', 'validUntil'),
			'deleteSession' => array('sessionID'),
			'getSessionInfo' => array('sessionID'),
			'listSessionsOfGroup' => array('groupID'),
			'listSessionsOfAuthor' => array('authorID'),
			
			// PAD CONTENT
			// Group pads are normal pads, but with the name schema
			// GROUPID$PADNAME. A security manager controls access of them and its
			// forbidden for normal pads to include a $ in the name.
			'getText' => array('padID', 'rev'),
			'setText' => array('padID', 'text'),
			'getHTML' => array('padID', 'rev'),
			'setHTML' => array('padID', 'html'),
			'getAttributePool' => array('padID'),
			'getRevisionChangeset' => array('padID', 'rev'),
			'createDiffHTML' => array('padID', 'startRev', 'endRev'),
			
			// CHAT
			'getChatHistory' => array('padID', 'start', 'end'),
			'getChatHead' => array('padID'),
			
			// PAD
			'createPad' => array('padID', 'text'),
			'getRevisionsCount' => array('padID'),
			'padUsersCount' => array('padID'),
			'padUsers' => array('padID'),
			'deletePad' => array('padID'),
			'copyPad' => array('sourceID', 'destinationID', 'force'),
			'movePad' => array('sourceID', 'destinationID', 'force'),
			'getReadOnlyID' => array('padID'),
			'getPadID' => array('readOnlyID'),
			'setPublicStatus' => array('padID', 'publicStatus'),
			'getPublicStatus' => array('padID'),
			'setPassword' => array('padID', 'password'),
			'isPasswordProtected' => array('padID'),
			'listAuthorsOfPad' => array('padID'),
			'getLastEdited' => array('padID'),
			'sendClientsMessage' => array('padID', 'msg'),
			'checkToken' => array(),
			
			// PADS
			'listAllPads' => array(),
		);
	}
	
	/* Returns details on a method, or all method details if no method set */
	public static function getMethodInfo($method = false) {
		$methods = array(
			'createGroup' => "creates a new group", 
			'createGroupIfNotExistsFor' => "this functions helps you to map your application group ids to etherpad lite group ids", 
			'deleteGroup' => "deletes a group", 
			'listPads' => "returns all pads of this group", 
			'createGroupPad' => "creates a new pad in this group", 
			'listAllGroups' => "lists all existing groups", 
			'createAuthor' => "creates a new author", 
			'createAuthorIfNotExistsFor' => "this functions helps you to map your application author ids to etherpad lite author ids", 
			'listPadsOfAuthor' => "returns an array of all pads this author contributed to", 
			'getAuthorName' => "Returns the Author Name of the author", 
			'createSession' => "creates a new session. validUntil is an unix timestamp in seconds", 
			'deleteSession' => "creates a new session. validUntil is an unix timestamp in seconds", 
			'getSessionInfo' => "returns informations about a session", 
			'listSessionsOfGroup' => "returns all sessions of a group", 
			'listSessionsOfAuthor' => "returns all sessions of an author", 
			'getText' => "returns the text of a pad", 
			'setText' => "sets the text of a pad", 
			'getHTML' => "returns the text of a pad formatted as HTML", 
			'setHTML' => "sets the html of a pad", 
			'getChatHistory' => "a part of the chat history, when start and end are given, the whole chat histroy, when no extra parameters are given", 
			'getChatHead' => "returns the chatHead (last number of the last chat-message) of the pad", 
			'createPad' => "creates a new '(non-group) pad. Note that if you need to create a group Pad, you should call createGroupPad.", 
			'getRevisionsCount' => "returns the number of revisions of this pad", 
			'padUsersCount' => "returns the number of user that are currently editing this pad", 
			'padUsers' => "returns the list of users that are currently editing this pad", 
			'deletePad' => "deletes a pad", 
			'getReadOnlyID' => "returns the read only link of a pad", 
			'setPublicStatus' => "sets a boolean for the public status of a pad", 
			'getPublicStatus' => "return true of false", 
			'setPassword' => "returns ok or a error message", 
			'isPasswordProtected' => "returns true or false", 
			'listAuthorsOfPad' => "returns an array of authors who contributed to this pad", 
			'getLastEdited' => "returns the timestamp of the last revision of the pad", 
			'sendClientsMessage' => "sends a custom message of type msg to the pad", 
			'checkToken' => "returns ok when the current api token is valid",  
			'listAllPads' => "lists all pads on this epl instance", 
		);
		if ($method) return $methods[$method];
		return $methods;
	}

}

