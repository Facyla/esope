<?php

namespace Sabre\DAV\Browser;

use
	Sabre\DAV,
	Sabre\HTTP\URLUtil,
	Sabre\HTTP\RequestInterface,
	Sabre\HTTP\ResponseInterface;

/**
 * Esope Browser Plugin
 *
 * This plugin provides a html representation, so that a WebDAV server may be accessed
 * using a browser.
 *
 * The class intercepts GET requests to collection resources and generates a simple
 * html index.
 *
 * @copyright Copyright (C) 2007-2014 fruux GmbH (https://fruux.com/).
 * @author Evert Pot (http://evertpot.com/)
 * @license http://sabre.io/license/ Modified BSD License
 */
class EsopePlugin extends DAV\Browser\Plugin {

	/**
	 * reference to server class
	 *
	 * @var Sabre\DAV\Server
	 */
	protected $server;

	/**
	 * enablePost turns on the 'actions' panel, which allows people to create
	 * folders and upload files straight from a browser.
	 *
	 * @var bool
	 */
	protected $enablePost = true;

	/**
	 * Creates the object.
	 *
	 * By default it will allow file creation and uploads.
	 * Specify the first argument as false to disable this
	 *
	 * @param bool $enablePost
	 */
	function __construct($enablePost=true) {
		$this->enablePost = $enablePost;
	}

	/**
	 * Initializes the plugin and subscribes to events
	 *
	 * @param DAV\Server $server
	 * @return void
	 */
	function initialize(DAV\Server $server) {
		$this->server = $server;
		$this->server->on('method:GET', [$this,'httpGet'], 200);
		$this->server->on('onHTMLActionsPanel', [$this, 'htmlActionsPanel'],200);
		if ($this->enablePost) $this->server->on('method:POST', [$this,'httpPOST']);
	}

	/**
	 * This method intercepts GET requests to collections and returns the html
	 *
	 * @param RequestInterface $request
	 * @param ResponseInterface $response
	 * @return bool
	 */
	function httpGet(RequestInterface $request, ResponseInterface $response) {
		// We're not using straight-up $_GET, because we want everything to be
		// unit testable.
		$getVars = $request->getQueryParameters();
		$sabreAction = isset($getVars['sabreAction'])?$getVars['sabreAction']:null;

		try {
			$this->server->tree->getNodeForPath($request->getPath());
		} catch (DAV\Exception\NotFound $e) {
			// We're simply stopping when the file isn't found to not interfere
			// with other plugins.
			return;
		}

		$response->setStatus(200);
		$response->setHeader('Content-Type','text/html; charset=utf-8');
		$response->setBody(
			$this->generateDirectoryIndex($request->getPath())
		);

		return false;
	}

	/**
	 * Handles POST requests for tree operations.
	 *
	 * @param RequestInterface $request
	 * @param ResponseInterface $response
	 * @return bool
	 */
	function httpPOST(RequestInterface $request, ResponseInterface $response) {
		$contentType = $request->getHeader('Content-Type');
		list($contentType) = explode(';', $contentType);
		if ($contentType !== 'application/x-www-form-urlencoded' && $contentType !== 'multipart/form-data') { return; }
		$postVars = $request->getPostData();
		if (!isset($postVars['sabreAction'])) return;
		$uri = $request->getPath();

		if ($this->server->emit('onBrowserPostAction', [$uri, $postVars['sabreAction'], $postVars])) {
			switch($postVars['sabreAction']) {
				case 'mkcol' :
					if (isset($postVars['name']) && trim($postVars['name'])) {
						// Using basename() because we won't allow slashes
						list(, $folderName) = URLUtil::splitPath(trim($postVars['name']));
						$this->server->createDirectory($uri . '/' . $folderName);
					}
					break;

				// @codeCoverageIgnoreStart
				case 'put' :
					if ($_FILES) $file = current($_FILES);
					else break;

					list(, $newName) = URLUtil::splitPath(trim($file['name']));
					if (isset($postVars['name']) && trim($postVars['name']))
						$newName = trim($postVars['name']);

					// Making sure we only have a 'basename' component
					list(, $newName) = URLUtil::splitPath($newName);

					if (is_uploaded_file($file['tmp_name'])) {
						$this->server->createFile($uri . '/' . $newName, fopen($file['tmp_name'],'r'));
					}
					break;
				// @codeCoverageIgnoreEnd
			}
		}
		$response->setHeader('Location', $request->getUrl());
		$response->setStatus(302);
		return false;
	}

	/**
	 * Escapes a string for html.
	 *
	 * @param string $value
	 * @return string
	 */
	function escapeHTML($value) {
		return htmlspecialchars($value,ENT_QUOTES,'UTF-8');
	}

	/**
	 * Generates the html directory index for a given url
	 *
	 * @param string $path
	 * @return string
	 */
	function generateDirectoryIndex($path) {
		$html = '';
		$version = '';
		//if (DAV\Server::$exposeVersion) { $version = DAV\Version::VERSION; }

		$vars = [
			'path'		=> $this->escapeHTML($path),
			'baseUrl'	 => $this->server->getBaseUri(),
		];

		// Title should be root "/" if empty, but have both starting and trailing slash otherwise
		$title = '/' . $vars['path'];
		if (!empty($vars['path'])) {
			$title .= '/';
			// Compute full URL - we use this method in case we have a "webdav" subfolder
			$breadcrumb_paths = explode('/', $vars['path']);
			$base_bc_path = explode('/webdav/', $vars['baseUrl']);
			unset($base_bc_path[0]);
			$base_bc_path = 'webdav/' . implode('/webdav/', $base_bc_path);
			$base_bc_path = elgg_get_site_url() . $base_bc_path;
			foreach($breadcrumb_paths as $breadcrumb_path) {
				$base_bc_path .= $breadcrumb_path . '/';
				elgg_push_breadcrumb($breadcrumb_path, $base_bc_path);
			}
		} else {
		}
		
		/* We don't really care about displaying the path, as we have breadcrumbs to do so...
		$html .= '<nav>';
		$html .= '<a href="' . $vars['baseUrl'] . $vars['path'] . '" class="btn">' . $vars['path'] . '/</a>';
		// If the path is empty, there's no parent.
		if ($path)	{
			list($parentUri) = URLUtil::splitPath($path);
			$fullPath = URLUtil::encodePath($this->server->getBaseUri() . $parentUri);
			$html.='<a href="' . $fullPath . '" class="btn" style="float:right;">⇤ ' . elgg_echo('elgg_webdav:browser:parent') . '</a>';
		} else {
			//$html.='<span class="btn disabled">⇤ Go to parent</span>';
		}

		$html.="</nav>";
		*/

		$node = $this->server->tree->getNodeForPath($path);
		if ($node instanceof DAV\ICollection) {
			//$html.='<section><h2>' . elgg_echo('elgg_webdav:browser:nodes') . '</h2>';

			$subNodes = $this->server->getPropertiesForChildren($path, [
				'{DAV:}displayname',
				'{DAV:}resourcetype',
				'{DAV:}getcontenttype',
				'{DAV:}getcontentlength',
				'{DAV:}getlastmodified',
			]);

			if ($subNodes) {
				$html.="<table class=\"nodeTable\">";
				foreach($subNodes as $subPath=>$subProps) {
					$subNode = $this->server->tree->getNodeForPath($subPath);
					$fullPath = URLUtil::encodePath($this->server->getBaseUri() . $subPath);
					list(, $displayPath) = URLUtil::splitPath($subPath);
					$subNodes[$subPath]['subNode'] = $subNode;
					$subNodes[$subPath]['fullPath'] = $fullPath;
					$subNodes[$subPath]['displayPath'] = $displayPath;
				}
				uasort($subNodes, [$this, 'compareNodes']);

				foreach($subNodes as $subProps) {
					$type = [
						'string' => 'Unknown',
						'icon'	 => 'cog',
					];
					if (isset($subProps['{DAV:}resourcetype'])) {
						$type = $this->mapResourceType($subProps['{DAV:}resourcetype']->getValue(), $subProps['subNode']);
					}

					$html.= '<tr>';
					$html.= '<td class="nameColumn"><a href="' . $this->escapeHTML($subProps['fullPath']) . '"><i class="fa fa-'.$type['icon'].'"></i> ' . $this->escapeHTML($subProps['displayPath']) . '</a></td>';
					$html.= '<td class="typeColumn">' . $type['string'] . '</td>';
					$html.= '<td>';
					if (isset($subProps['{DAV:}getcontentlength'])) {
						$html.=$subProps['{DAV:}getcontentlength'] . ' bytes';
					}
					$html.= '</td><td>';
					if (isset($subProps['{DAV:}getlastmodified'])) {
						$lastMod = $subProps['{DAV:}getlastmodified']->getTime();
						$html.=$lastMod->format('F j, Y, g:i a');
					}
					$html.= '</td></tr>';
				}
				$html.= '</table>';
			} else {
				$html.= '<p>' . elgg_echo('elgg_webdav:browser:nocontent') . '</p>';
			}
		}

		/* Start of generating actions */
		$output = '';
		if ($this->enablePost) {
			$this->server->emit('onHTMLActionsPanel', [$node, &$output]);
		}

		if ($output) {
			$html.="<div class=\"actions\">\n";
			//$html.='<h2>' . elgg_echo('elgg_webdav:browser:actions') . '</h2>';
			$html.=$output;
			$html.="</div>\n";
		}
		
		if (elgg_is_admin_logged_in()) {
			$html.="<div class=\"properties\">\n";
			//$html.='<h2>' . elgg_echo('elgg_webdav:browser:properties') . '</h2>';;
			$html.="<table class=\"propTable\">";
			// Allprops request
			$propFind = new PropFindAll($path);
			$properties = $this->server->getPropertiesByNode($propFind, $node);
			$properties = $propFind->getResultForMultiStatus()[200];
			foreach($properties as $propName => $propValue) {
				$html.=$this->drawPropertyRow($propName, $propValue);
			}
			$html.="</table>";
			$html.="</div>\n";
		}
		
		
		$this->server->httpResponse->setHeader('Content-Security-Policy', "img-src 'self'; style-src 'self';");
		
		// Wrap into Elgg interface
		$content = '<div class="elgg-webdav">' . $html . '</div>';
		$body = elgg_view_layout('one_column', array('content' => $content, 'title' => $title));
		return elgg_view_page($title, $body);
	}

	/**
	 * This method is used to generate the 'actions panel' output for
	 * collections.
	 *
	 * This specifically generates the interfaces for creating new files, and
	 * creating new directories.
	 *
	 * @param DAV\INode $node
	 * @param mixed $output
	 * @return void
	 */
	function htmlActionsPanel(DAV\INode $node, &$output) {
		if (!$node instanceof DAV\ICollection) return;

		// We also know fairly certain that if an object is a non-extended
		// SimpleCollection, we won't need to show the panel either.
		if (get_class($node)==='Sabre\\DAV\\SimpleCollection') return;

		ob_start();
		echo '<form method="post" action="">
		<fieldset><legend>' . elgg_echo('elgg_webdav:browser:createfolder') . '</legend>
		<input type="hidden" name="sabreAction" value="mkcol" />
		<table><tr><td>
			<label>' . elgg_echo('elgg_webdav:browser:foldername') . ' : <input type="text" name="name" /></label><br />
		</td><td>
			<input type="submit" value="' . elgg_echo('elgg_webdav:browser:create') . '" class="elgg-button elgg-button-submit" />
			<div class="clearfloat"></div>
		</td></tr></table>
		</fieldset>
		</form>
		<div class="clearfloat"></div>
		
		<form method="post" action="" enctype="multipart/form-data">
		<fieldset><legend>' . elgg_echo('elgg_webdav:browser:uploadfile') . '</legend>
		<input type="hidden" name="sabreAction" value="put" />
		<table><tr><td>
			<label>' . elgg_echo('elgg_webdav:browser:filename') . ' : <input type="text" name="name" /></label><br />
			<label>' . elgg_echo('elgg_webdav:browser:file') . ' : <input type="file" name="file" /></label><br />
		</td><td>
				<input type="submit" value="' . elgg_echo('elgg_webdav:browser:upload') . '" class="elgg-button elgg-button-submit" />
				<div class="clearfloat"></div>
		</td></tr></table>
		</fieldset>
		</form>
		<div class="clearfloat"></div>
		';

		$output.=ob_get_clean();
	}


	/**
	 * Sort helper function: compares two directory entries based on type and
	 * display name. Collections sort above other types.
	 *
	 * @param array $a
	 * @param array $b
	 * @return int
	 */
	protected function compareNodes($a, $b) {
		$typeA = (isset($a['{DAV:}resourcetype']))
			? (in_array('{DAV:}collection', $a['{DAV:}resourcetype']->getValue()))
			: false;

		$typeB = (isset($b['{DAV:}resourcetype']))
			? (in_array('{DAV:}collection', $b['{DAV:}resourcetype']->getValue()))
			: false;

		// If same type, sort alphabetically by filename:
		if ($typeA === $typeB) {
			return strnatcasecmp($a['displayPath'], $b['displayPath']);
		}
		return (($typeA < $typeB) ? 1 : -1);
	}

	/**
	 * Maps a resource type to a human-readable string and icon.
	 *
	 * @param array $resourceTypes
	 * @param INode $node
	 * @return array
	 */
	private function mapResourceType(array $resourceTypes, $node) {
		if (!$resourceTypes) {
			if ($node instanceof DAV\IFile) {
				return [
					'string' => elgg_echo('elgg_webdav:types:file'),
					'icon'	 => 'file',
				];
			} else {
				return [
					'string' => elgg_echo('elgg_webdav:types:unknown'),
					'icon'	 => 'cog',
				];
			}
		}

		$types = [
			'{http://calendarserver.org/ns/}calendar-proxy-write' => [
				'string' => elgg_echo('elgg_webdav:types:proxy-write'),
				'icon'	 => 'people',
			],
			'{http://calendarserver.org/ns/}calendar-proxy-read' => [
				'string' => elgg_echo('elgg_webdav:types:proxy-read'),
				'icon'	 => 'people',
			],
			'{urn:ietf:params:xml:ns:caldav}schedule-outbox' => [
				'string' => elgg_echo('elgg_webdav:types:outbox'),
				'icon'	 => 'inbox',
			],
			'{urn:ietf:params:xml:ns:caldav}schedule-inbox' => [
				'string' => elgg_echo('elgg_webdav:types:inbox'),
				'icon'	 => 'inbox',
			],
			'{urn:ietf:params:xml:ns:caldav}calendar' => [
				'string' => elgg_echo('elgg_webdav:types:calendar'),
				'icon'	 => 'calendar',
			],
			'{http://calendarserver.org/ns/}shared-owner' => [
				'string' => elgg_echo('elgg_webdav:types:shared-owner'),
				'icon'	 => 'calendar',
			],
			'{http://calendarserver.org/ns/}subscribed' => [
				'string' => elgg_echo('elgg_webdav:types:subscribed'),
				'icon'	 => 'calendar',
			],
			'{urn:ietf:params:xml:ns:carddav}directory' => [
				'string' => elgg_echo('elgg_webdav:types:directory'),
				'icon'	 => 'globe',
			],
			'{urn:ietf:params:xml:ns:carddav}addressbook' => [
				'string' => elgg_echo('elgg_webdav:types:addressbook'),
				'icon'	 => 'book',
			],
			'{DAV:}principal' => [
				'string' => elgg_echo('elgg_webdav:types:principal'),
				'icon'	 => 'person',
			],
			'{DAV:}collection' => [
				'string' => elgg_echo('elgg_webdav:types:collection'),
				'icon'	 => 'folder',
			],
		];

		$info = [
			'string' => [],
			'icon' => 'cog',
		];
		foreach($resourceTypes as $k=> $resourceType) {
			if (isset($types[$resourceType])) {
				$info['string'][] = $types[$resourceType]['string'];
			} else {
				$info['string'][] = $resourceType;
			}
		}
		foreach($types as $key=>$resourceInfo) {
			if (in_array($key, $resourceTypes)) {
				$info['icon'] = $resourceInfo['icon'];
				break;
			}
		}
		$info['string'] = implode(', ', $info['string']);
		return $info;
	}

	/**
	 * Draws a table row for a property
	 *
	 * @param string $name
	 * @param mixed $value
	 * @return string
	 */
	private function drawPropertyRow($name, $value) {
		$view = 'unknown';
		if (is_string($value)) {
			$view = 'string';
		} elseif($value instanceof DAV\Property) {

			$mapping = [
				'Sabre\\DAV\\Property\\IHref' => 'href',
				'Sabre\\DAV\\Property\\HrefList' => 'hreflist',
				'Sabre\\DAV\\Property\\SupportedMethodSet' => 'valuelist',
				'Sabre\\DAV\\Property\\ResourceType' => 'xmlvaluelist',
				'Sabre\\DAV\\Property\\SupportedReportSet' => 'xmlvaluelist',
				'Sabre\\DAVACL\\Property\\CurrentUserPrivilegeSet' => 'xmlvaluelist',
				'Sabre\\DAVACL\\Property\\SupportedPrivilegeSet' => 'supported-privilege-set',
			];

			$view = 'complex';
			foreach($mapping as $class=>$val) {
				if ($value instanceof $class) {
					$view = $val;
					break;
				}
			}
		}

		list($ns, $localName) = DAV\XMLUtil::parseClarkNotation($name);

		$realName = $name;
		if (isset($this->server->xmlNamespaces[$ns])) {
			$name = $this->server->xmlNamespaces[$ns] . ':' . $localName;
		}

		ob_start();

		$xmlValueDisplay = function($propName) {
			$realPropName = $propName;
			list($ns, $localName) = DAV\XMLUtil::parseClarkNotation($propName);
			if (isset($this->server->xmlNamespaces[$ns])) {
				$propName = $this->server->xmlNamespaces[$ns] . ':' . $localName;
			}
			return "<span title=\"" . $this->escapeHTML($realPropName) . "\">" . $this->escapeHTML($propName) . "</span>";
		};

		echo "<tr><th><span title=\"", $this->escapeHTML($realName), "\">", $this->escapeHTML($name), "</span></th><td>";

		switch($view) {
			case 'href' :
				echo "<a href=\"" . $this->server->getBaseUri() . $value->getHref() . '">' . $this->server->getBaseUri() . $value->getHref() . '</a>';
				break;
			case 'hreflist' :
				echo implode('<br />', array_map(function($href) {
					if (stripos($href,'mailto:')===0 || stripos($href,'/')===0 || stripos($href,'http:')===0 || stripos($href,'https:') === 0) {
						return "<a href=\"" . $this->escapeHTML($href) . '">' . $this->escapeHTML($href) . '</a>';
					} else {
						return "<a href=\"" . $this->escapeHTML($this->server->getBaseUri() . $href) . '">' . $this->escapeHTML($this->server->getBaseUri() . $href) . '</a>';
					}
				}, $value->getHrefs()));
				break;
			case 'xmlvaluelist' :
				echo implode(', ', array_map($xmlValueDisplay, $value->getValue()));
				break;
			case 'valuelist' :
				echo $this->escapeHTML(implode(', ', $value->getValue()));
				break;
			case 'supported-privilege-set' :
				$traverse = function($priv) use (&$traverse, $xmlValueDisplay) {
					echo "<li>";
					echo $xmlValueDisplay($priv['privilege']);
					if (isset($priv['abstract']) && $priv['abstract']) {
						echo " <i>(abstract)</i>";
					}
					if (isset($priv['description'])) {
						echo " " . $this->escapeHTML($priv['description']);
					}
					if (isset($priv['aggregates'])) {
						echo "\n<ul>\n";
						foreach($priv['aggregates'] as $subPriv) {
							$traverse($subPriv);
						}
						echo "</ul>";
					}
					echo "</li>\n";
				};
				echo "<ul class=\"tree\">";
				$traverse($value->getValue(), '');
				echo "</ul>\n";
				break;
			case 'string' :
				echo $this->escapeHTML($value);
				break;
			case 'complex' :
				echo '<em title="' . get_class($value) . '">complex</em>';
				break;
			default :
				echo '<em>unknown</em>';
				break;
		}

		return ob_get_clean();
	}

}

