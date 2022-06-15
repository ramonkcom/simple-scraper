<?php 

namespace RamonK\SimpleScraper;

use PHPUnit\Framework\TestCase;


class SimpleScraperTest extends TestCase{
    public function testCreation()
    {
        $ss = new SimpleScraper('https://www.huffingtonpost.com/');
        $this->assertInstanceOf(SimpleScraper::class, $ss);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCreationBadUrl()
    {
        $ss = new SimpleScraper('');
    }

    /**
     * This site was originally throwing errors, changes to
     * headers seems to fix it.
     */
    public function testHubspotUrl()
    {
        $ss = new SimpleScraper ('https://blog.hubspot.com/marketing/facebook-pixel');
        $this->assertInstanceOf(SimpleScraper::class, $ss);
    }

}
