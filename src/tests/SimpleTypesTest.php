<?php
namespace PubNub\CborCodec\Tests;

use PHPUnit\Framework\TestCase;
use PubNub\CborCodec\CBOR;

class SimpleTypesTest extends TestCase
{
    use Traits\DataProviders;

    /**
     * @dataProvider primitives
     */
    public function testPrimitives($input, $expected)
    {
        $decoded = CBOR::decode($input);
        $this->assertEquals($expected, $decoded);
    }

    /**
     * @dataProvider positiveIntegers
     */
    public function testPositiveIntegers($input, $expected)
    {
        $decoded = CBOR::decode($input);
        $this->assertEquals($expected, $decoded);
    }

    /**
     * @dataProvider negativeIntegers
     */
    public function testNegativeIntegers($input, $expected)
    {
        $decoded = CBOR::decode($input);
        $this->assertEquals($expected, $decoded);
    }

    /**
     * @dataProvider floats
     */
    public function testFloats($input, $expected)
    {
        $decoded = CBOR::decode($input);
        $this->assertEquals($expected, $decoded);
    }

    /**
     * @dataProvider byteStrings
     */
    public function testByteStrings($input, $expected)
    {
        $decoded = CBOR::decode($input);
        $this->assertEquals($expected, $decoded);
    }

    /**
     * @dataProvider utf8Strings
     */
    public function testUtfStrings($input, $expected)
    {
        $decoded = CBOR::decode($input);
        $this->assertEquals($expected, $decoded);
    }
}
