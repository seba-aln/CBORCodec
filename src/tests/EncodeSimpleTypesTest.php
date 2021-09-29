<?php

declare(strict_types=1);

namespace PubNub\CborCodec\Tests;

use PHPUnit\Framework\TestCase;
use PubNub\CborCodec\CBOR;

class EncodeSimpleTypesTest extends TestCase
{
    use Traits\DataProviders;

    /**
     * @dataProvider primitives
     */
    public function testEncodePrimitives($expected, $input)
    {
        $encoded = CBOR::encode($input);
        $this->assertEquals($expected, $encoded);
    }

    /**
     * @dataProvider positiveIntegers
     */
    public function testEncodePositiveIntegers($expected, $input)
    {
        $encoded = CBOR::encode((int)$input);
        $this->assertEquals($expected, $encoded);
    }

    /**
     * @dataProvider negativeIntegers
     */
    public function testEncodeNegativeIntegers($expected, $input)
    {
        $encoded = CBOR::encode($input);
        $this->assertEquals($expected, $encoded);
    }

    /**
     * @dataProvider doublePrecision
     */
    public function testFloats($expected, $input)
    {
        $encoded = CBOR::encode($input);
        $this->assertEquals($expected, $encoded);
    }

    /**
     * @dataProvider byteStrings
     */
    public function testByteStrings($expected, $input)
    {
        $encoded = CBOR::encode($input, CBOR::TYPE_BYTE_STRING);
        $this->assertEquals($expected, $encoded);
    }

    /**
     * @dataProvider utf8Strings
     */
    public function testUtfStrings($expected, $input)
    {
        $encoded = CBOR::encode($input);
        $this->assertEquals($expected, $encoded);
    }
}
