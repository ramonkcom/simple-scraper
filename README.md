# SimpleScraper

SimpleScraper allows you to fetch Open Graph Protocol data, Twitter Card data and/or meta tags data.

## Basic Usage

### Installation

Install the latest version with:

```bash
$ composer require ramonztro/simple-scraper
```

### Basic Usage

```php
<?php

use Ramonztro\SimpleScraper\SimpleScraper;

try {
	//Creates a scraper
	$scraper = new SimpleScraper('http://localhost/~ramonztro/simple-scraper/doscrape.php?url=https://techcrunch.com/2016/06/16/neural-networks-artificial-intelligence-and-our-future/');
	
	//Returns an array containing OGP meta values. The array is indexed by the property attribute of the meta tag. In this case:
	/* 
		array(7) { 
			["site_name"]=> string(10) "TechCrunch" 
			["site"]=> string(21) "social.techcrunch.com" 
			["title"]=> string(56) "Neural networks: Artificial intelligence and ourÂ future" 
			["description"]=> string(160) "Imagine yourself a passenger in a futuristic self-driving car. Instead of programming its navigation system, the car interacts with you in a near-human way to.." 
			["image"]=> string(97) "https://tctechcrunch2011.files.wordpress.com/2016/06/gettyimages-512343611.jpg?w=764&h=400&crop=1" 
			["url"]=> string(95) "http://social.techcrunch.com/2016/06/16/neural-networks-artificial-intelligence-and-our-future/" 
			["type"]=> string(7) "article" }
	*/
	$ogpData = $scraper->getOgp();
	
	//Returns an array containing Twitter meta values. The array is indexed by the name attribute of the meta tag. In this case:
	/* 
		array(6) { 
			["card"]=> string(19) "summary_large_image" 
			["image:src"]=> string(97) "https://tctechcrunch2011.files.wordpress.com/2016/06/gettyimages-512343611.jpg?w=764&h=400&crop=1" 
			["site"]=> string(11) "@techcrunch" 
			["url"]=> string(89) "https://techcrunch.com/2016/06/16/neural-networks-artificial-intelligence-and-our-future/" 
			["description"]=> string(198) "Imagine yourself a passenger in a futuristic self-driving car. Instead of programming its navigation system, the car interacts with you in a near-human way to understand your desired destination.â€¦" 
			["title"]=> string(60) "Neural networks: Artificial intelligence and our future |â€¦" 
		}
	*/
	$twitterData = $scraper->getTwitter();
	
	//Returns an array containing Twitter meta values. The array is indexed by the name attribute of the meta tag. In this case:
	/* 
		array(33) { 
			["robots"]=> string(12) "NOYDIR,NOODP"
			["generator"]=> string(13) "WordPress.com"
			["tag"]=> string(24) "unmanned aerial vehicles" 
			["description"]=> string(160) "Imagine yourself a passenger in a futuristic self-driving car. Instead of programming its navigation system, the car interacts with you in a near-human way to.." 
			["application-name"]=> string(10) "TechCrunch"
			// goes on
		}
	*/
	$metaData = $scraper->getMeta();
} catch (Exception $e) {
	//Handles error
	die($e->getMessage());
}

```

## About

### Requirements

- PHP 5.3 or higher.

### MIT License

*Permission is hereby granted, free of charge, to any person obtaining a copy * 
of this software and associated documentation files (the "Software"), to    
deal in the Software without restriction, including without limitation the  
rights to use, copy, modify, merge, publish, distribute, sublicense, and/or 
sell copies of the Software, and to permit persons to whom the Software is  
furnished to do so, subject to the following conditions:*                    
                                                                            
*The above copyright notice and this permission notice shall be included in  
all copies or substantial portions of the Software.*                         
                                                                            
*THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR  
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,    
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE 
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER      
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING     
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS * 
IN THE SOFTWARE.*

### Author

Ramon Kayo - <contato@ramonkayo.com> - <http://twitter.com/ramonztro>
