<?php 

namespace Ramonztro\SimpleScraper;

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
}