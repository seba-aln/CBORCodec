<?php
namespace PubNub\CborCodec\Tests;

use PHPUnit\Framework\TestCase;
use PubNub\CborCodec\CBOR;

class HashMapsTest extends TestCase
{
    use Traits\DataProviders;

    /**
     * @dataProvider hashMaps
     */
    public function testDecodeHashMaps($input, $expected)
    {
        $decoded = CBOR::decode($input);
        $this->assertEquals($expected, $decoded);
    }
}
