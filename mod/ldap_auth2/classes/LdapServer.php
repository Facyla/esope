<?php
class LdapServer {
	private $_host;
	private $_port;
	private $_version;
	private $_link;
	private $_basedn;
	private $_bind_rdn;
	private $_bind_password;

	public function __construct(array $options = null) {
		if (is_array($options)) {
			$this->setOptions($options);
		}
		$this->setDefaults();
	}
	public function __destruct() {
		if($this->_link) {
			ldap_close($this->_link);
		}
	}
	public function __set($name, $value) {
		$method = 'set' . $name;
		if (!method_exists($this, $method)) {
			throw new Exception('Invalid LdapServer property');
		}
		$this->$method($value);
	}

	public function __get($name) {
		$method = 'get' . $name;
		if (!method_exists($this, $method)) {
			throw new Exception('Invalid LdapServer property '.$method);
		}
		return $this->$method();
	}

	public function setOptions(array $options) {
		$methods = get_class_methods($this);
		foreach ($options as $key => $value) {
			$method = 'set' . ucfirst($key);
			if (in_array($method, $methods)) {
				$this->$method($value);
			}
		}
		return $this;
	}
	protected function setDefaults() {
		if(!$this->_port) {
			$this->_port = 389;
		}
		if (!$this->_version) {
			$this->_version = 3;
		}
	}
	public function setHost($text) {
		$this->_host = (string) $text;
		return $this;
	}

	public function getHost() {
		return $this->_host;
	}

	public function setPort($int) {
		$this->_port = (int) $int;
		return $this;
	}

	public function getPort() {
		return $this->_port;
	}
	public function setVersion($int) {
		$this->_version = (int) $int;
		return $this;
	}
	
	public function getVersion() {
		return $this->_version;
	}
	public function setBasedn($ts) {
		$this->_basedn = $ts;
		return $this;
	}

	public function getBasedn() {
		return $this->_basedn;
	}


	public function getBind_rdn() {
		return $this->_bind_rdn;
	}
	public function getBind_password() {
		return $this->_bind_password;
	}
	public function getLink() {
		if(!$this->_link){
			$this->_link = ldap_connect($this->getHost(),$this->getPort());
			ldap_set_option($this->_link, LDAP_OPT_PROTOCOL_VERSION, $this->getversion());
			ldap_set_option($this->_link, LDAP_OPT_DEBUG_LEVEL, 255);
			ldap_set_option($this->_link, LDAP_OPT_REFERRALS, 0);
			ldap_set_option($this->_link, LDAP_OPT_NETWORK_TIMEOUT, 5);
		}
		return $this->_link;
	}
	
	/**
	 * Search LDAP tree
	 * @param filter string
	 * The search filter can be simple or advanced, using boolean operators in
	 * the format described in the LDAP documentation (see the Netscape Directory SDK for full
	 * information on filters).
	 * @param attributes array[optional]
	 * An array of the required attributes, e.g. array("mail", "sn", "cn").
	 * Note that the "dn" is always returned irrespective of which attributes
	 * types are requested.
	 * Using this parameter is much more efficient than the default action
	 * (which is to return all attributes and their associated values). 
	 * The use of this parameter should therefore be considered good
	 * practice.
	 * @param attrsonly int[optional]
	 * Should be set to 1 if only attribute types are wanted. If set to 0
	 * both attributes types and attribute values are fetched which is the
	 * default behaviour.
	 * @param sizelimit int[optional]
	 * Enables you to limit the count of entries fetched. Setting this to 0
	 * means no limit.
	 * This parameter can NOT override server-side preset sizelimit. You can
	 * set it lower though.
	 * Some directory server hosts will be configured to return no more than
	 * a preset number of entries. If this occurs, the server will indicate
	 * that it has only returned a partial results set. This also occurs if
	 * you use this parameter to limit the count of fetched entries.
	 * @param timelimit int[optional]
	 * Sets the number of seconds how long is spend on the search. Setting
	 * this to 0 means no limit.
	 * This parameter can NOT override server-side preset timelimit. You can
	 * set it lower though.
	 * @param deref int[optional]
	 * Specifies how aliases should be handled during the search. It can be
	 * one of the following:
	 * LDAP_DEREF_NEVER - (default) aliases are never
	 * dereferenced.
	 * @return array Result entries or false on error.
	 */
	public function search($filter, array $attributes = array(), $attrsonly = null, $sizelimit = null, $timelimit = null, $deref = null){
		
		$qry = ldap_search($this->getLink(), $this->getBaseDN(), $filter, $attributes, $attrsonly, $sizelimit, $timelimit, $deref);
		
		$entry = ldap_first_entry($this->getLink(), $qry);
		if ($entry) {
			//if ((count($attributes) < 1) && ($attributes != 'rdn')) $attributes = ldap_get_attributes($this->getLink(), $entry);
			if ($attributes[0] == "*") {
				$get_attributes = ldap_get_attributes($this->getLink(), $entry);
				$count = $get_attributes['count'];
				//$get_attributes = array_pop($get_attributes); // Remove "count" entry
				for ($i = 0; $i < $count; $i++) {
					$attributes[] = $get_attributes[$i];
				}
				if (is_array($attributes)) { $test = print_r($attributes, true); error_log($test); }
			}
			while ($entry) {
				if (is_array($attributes) && count($attributes) > 0 ) {
					foreach ($attributes as $attribute) {
						$values = array();
						// "ldap_get_values(): Cannot get the value(s) of attribute Decoding error" in file /appli/devnet/elgg/mod/ldap_auth2/classes/LdapServer.php (line 171)
						//"ldap_get_values() expects parameter 3 to be string, array given" in file /appli/devnet/elgg/mod/ldap_auth2/classes/LdapServer.php (line 171)
						if (is_array($attribute)) { $test = print_r($attribute, true); error_log($test); }
						$vals = ldap_get_values($this->getLink(), $entry, $attribute);
						for ($i=0;$i < $vals['count'];$i++) {
							 $values[]=$vals[$i];
						}
						// "Illegal offset type" in file /appli/devnet/elgg/mod/ldap_auth2/classes/LdapServer.php (line 175)
						$result[$attribute] = $values;
					}
				} else {
					$result = ldap_get_dn($this->getLink(), $entry);
				}
				$results[] = $result;
				$entry = ldap_next_entry($this->getLink(), $entry);
			}
			ldap_free_result($qry);
			return $results;
		}
		return false;
	}
	
	/**
	 * Bind to LDAP directory
	 * @param bind_rdn string[optional]
	 * @param bind_password string[optional]
	 * @return bool Returns true on success or false on failure.
	 */
	public function bind($rdn=null, $password=null) {
		return ldap_bind($this->getLink(), $rdn, $password);
	}
	
}

