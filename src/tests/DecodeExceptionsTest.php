<?php
namespace PubNub\CborCodec\Tests;

use PHPUnit\Framework\TestCase;
use PubNub\CborCodec\CBOR;

class DecodeExceptionsTest extends TestCase
{
    public function testInvalidInput()
    {
        $this->expectException(\Exception::class);
        CBOR::decode('EFGHI');
    }

    public function testValidInput()
    {
        $result = CBOR::decode('46 50 75 62 4e 75 62');
        $this->assertEquals('PubNub', $result);
    }
}
