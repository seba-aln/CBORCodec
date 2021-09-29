<?php

declare(strict_types=1);

namespace PubNub\CborCodec\Tests;

use PHPUnit\Framework\TestCase;
use PubNub\CborCodec\CBOR;

class DecodeArraysTest extends TestCase
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
