<?php

namespace UnitTests\Response;

use PhpTwinfield\Response\HeaderBag;
use PHPUnit\Framework\TestCase;

class HeaderBagUnitTest extends TestCase
{
    public function testFromStringAndGet()
    {
        $rawHeaders = "Content-Type: application/json\r\nX-Custom-Header: CustomValue\r\n";
        $headerBag = HeaderBag::fromString($rawHeaders);

        $this->assertEquals('application/json', $headerBag->get('Content-Type'));
        $this->assertEquals('CustomValue', $headerBag->get('X-Custom-Header'));
        $this->assertNull($headerBag->get('Non-Existent-Header'));
    }

    public function testGetWithDefault()
    {
        $rawHeaders = "Content-Type: application/json\r\n";
        $headerBag = HeaderBag::fromString($rawHeaders);

        $this->assertEquals('application/json', $headerBag->get('Content-Type', 'default'));
        $this->assertEquals('default', $headerBag->get('Non-Existent-Header', 'default'));
    }

    public function testEmptyHeaders()
    {
        $headerBag = HeaderBag::fromString('');

        $this->assertNull($headerBag->get('Any-Header'));
    }

    public function testGetCaseInsensitive()
    {
        $rawHeaders = "Content-Type: application/json\r\nX-Custom-Header: CustomValue\r\n";
        $headerBag = HeaderBag::fromString($rawHeaders);

        $this->assertEquals('application/json', $headerBag->get('content-type'));
        $this->assertEquals('CustomValue', $headerBag->get('x-custom-header'));
    }
}
