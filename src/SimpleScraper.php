<?php
/*
+---------------------------------------------------------------------------+
| SimpleScraper                                                             |
| Copyright (c) 2013-2016, Ramon Kayo                                       |
+---------------------------------------------------------------------------+
| Author        : Ramon Kayo                                                |
| Email         : contato@ramonk.com                                        |
| License       : Distributed under the MIT License                         |
| Full license  : https://github.com/ramonkcom/simple-scraper               |
+---------------------------------------------------------------------------+
| "Simplicity is the ultimate sophistication." - Leonardo Da Vinci          |
+---------------------------------------------------------------------------+
*/
namespace RamonK\SimpleScraper;

use \DOMDocument;
use \Exception;
use \InvalidArgumentException;

class SimpleScraper {
	
	private
		$contentType,
		$data,
		$content,
		$httpCode,
		$url;
/*===========================================================================*/
// CONSTRUCTOR
/*===========================================================================*/
	/**
	 * 
	 * @param string $url
	 * @throws Exception
	 */
	public function __construct($url, $userAgent ='', $proxy = '') {
		$this->data = array(
			'ogp' => array(),
			'twitter' => array(),
			'meta' => array()
		);
		
		$urlPattern = '~^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)(?:\.(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)*(?:\.(?:[a-z\x{00a1}-\x{ffff}]{2,})))(?::\d{2,5})?(?:/[^\s]*)?$~iu';
		if (!is_string($url))
			throw new InvalidArgumentException("Argument 'url' is invalid (not a string).");
		if (!(preg_match($urlPattern, $url)))
			throw new InvalidArgumentException("Argument 'url' is invalid.");
		$this->url = $url;
		if (empty($userAgent))
			$this->userAgent = 'Mozilla/5.0 (compatible; SimpleScraper)';
		else
			$this->userAgent = $userAgent;
		if (!empty($proxy))
			$this->proxy = $proxy;

		$this->fetchResource();
		libxml_use_internal_errors(true);
		$dom = new DOMDocument(null, 'UTF-8');
		$dom->loadHTML($this->content);
		$metaTags = $dom->getElementsByTagName('meta');

		for ($i=0; $i<$metaTags->length; $i++) {
			$attributes = $metaTags->item($i)->attributes;
			$attrArray = array();
			foreach ($attributes as $attr) $attrArray[$attr->nodeName] = $attr->nodeValue;
			
			if (
				array_key_exists('property', $attrArray) && 
				preg_match('~og:([a-zA-Z:_]+)~', $attrArray['property'], $matches)
			) {
				$this->data['ogp'][$matches[1]] = $attrArray['content'];
			} else if (
				array_key_exists('name', $attrArray) &&
				preg_match('~twitter:([a-zA-Z:_]+)~', $attrArray['name'], $matches)
			) {
				$this->data['twitter'][$matches[1]] = $attrArray['content'];
			} else if (
				array_key_exists('name', $attrArray) &&
				array_key_exists('content', $attrArray)
			) {
				$this->data['meta'][$attrArray['name']] = $attrArray['content'];
			}
		}
	}
	
/*===========================================================================*/
// PUBLIC METHODS
/*===========================================================================*/
	/**
	 *
	 * @return array
	 */
	public function getAllData() {
		return $this->data;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getContent() {
		return $this->content;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getContentType() {
		return $this->contentType;
	}

	/**
	 *
	 * @return string
	 */
	public function getHttpCode() {
		return $this->httpCode;
	}
	
	/**
	 *
	 * @return array
	 */
	public function getMeta() {
		return $this->data['meta'];
	}
	
	/**
	 *
	 * @return array
	 */
	public function getOgp() {
		return $this->data['ogp'];
	}
	
	/**
	 *
	 * @return array
	 */
	public function getTwitter() {
		return $this->data['twitter'];
	}
	
/*===========================================================================*/
// PRIVATE METHODS
/*===========================================================================*/
	private function fetchResource() {
		$headers = [
			'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
			'Accept-Encoding: gzip, deflate',
			'Accept-Language: en-US,en;q=0.5',
		];
		
		$ch = curl_init();
		if( isset( $this->proxy ) )
			curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
		curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_TCP_NODELAY, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$this->content = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);
		
		$this->httpCode = $info['http_code'];
		$this->contentType = $info['content_type'];
		
		if (((int) $this->httpCode) >= 400) {
			throw new Exception('STATUS CODE: ' . $this->httpCode);
		}
	}
}
