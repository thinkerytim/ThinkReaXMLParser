<?php

use ThinkReaXMLParser\Objects\FloorplanObject;
use ThinkReaXMLParser\Objects\ImageObject;
use ThinkReaXMLParser\Objects\Listings\ResidentialListing;

class ResidentialListingTest extends PHPUnit_Framework_TestCase
{
    protected $xml;

    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->xml = simplexml_load_file("stubs/residentiallisting.xml");
    }
    
    public function tearDown()
    {
        parent::tearDown(); // TODO: Change the autogenerated stub
    }

    public function testResidentialListingsParser()
    {
        $parsed = new ResidentialListing($this->xml);

        $this->assertSame('ABCD1234', $parsed->getUniqueId());
        $this->assertSame('XNWXNW', $parsed->getAgent()->getAgentID());
        $this->assertSame('Mr. John Doe', $parsed->getAgent()->getName());
        $this->assertInstanceOf(ResidentialListing::class, $parsed);
        $this->assertInstanceOf(ImageObject::class, $parsed->getMedia()->getImages()[0]);
        $this->assertSame('http://www.realestate.com.au/tmp/imageM.jpg', $parsed->getMedia()->getImages()[0]->getUrl());
        $this->assertSame(1, $parsed->getMedia()->getImages()[0]->getOrdering());
        $this->assertCount(2, $parsed->getMedia()->getImages());
        $this->assertInstanceOf(FloorplanObject::class, $parsed->getMedia()->getFloorplans()[0]);
        $this->assertSame('http://www.realestate.com.au/tmp/floorplan1.gif', $parsed->getMedia()->getFloorplans()[0]->getUrl());
        $this->assertCount(2, $parsed->getMedia()->getFloorplans());
        $this->assertSame('current', $parsed->getStatus());
        $this->assertSame('SHOW STOPPER!!!', $parsed->getTitle());
        $this->assertSame('House', $parsed->getCategory());
        $this->assertSame('Yarra', $parsed->getMunicipality());
        $this->assertSame('Yarra', $parsed->getAddress()->getMunicipality());
        $this->assertSame(500000, $parsed->getPrice());
        $this->assertSame("Between $400,000 and $600,000", $parsed->getPriceView());
        $this->assertTrue($parsed->getDisplayPrice());
        $this->assertInstanceOf(\Carbon\Carbon::class, $parsed->getModified());
    }
}
