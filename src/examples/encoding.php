<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use PubNub\CborCodec\CBOR;

$int = 2345342;
var_dump(CBOR::encode($int));

// but this is not the same as passing the string with int in it.
$intString = '2345342';
var_dump(CBOR::encode($intString));


$string = 'This Is A String';
var_dump(CBOR::encode($string)); // should yield '7054686973204973204120537472696E67';

var_dump(CBOR::encode($string, CBOR::TYPE_BYTE_STRING));
var_dump(CBOR::encode(new stdClass()));
