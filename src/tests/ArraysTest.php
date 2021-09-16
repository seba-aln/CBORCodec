<?php
namespace PubNub\CborCodec\Tests;

use PHPUnit\Framework\TestCase;
use PubNub\CborCodec\CBOR;

class ArraysTest extends TestCase
{
    use Traits\DataProviders;

    /**
     * @dataProvider arrays
     */
    public function testDecodeArrays($input, $expected)
    {
        $decoded = CBOR::decode($input);
        $this->assertEquals($expected, $decoded);
    }
}