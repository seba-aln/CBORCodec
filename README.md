Simple and fast coder/decoder for CBOR

This is the official PubNub CBOR PHP encoder/decoder


### Examples:
It's extremely simple to encode and decode basic PHP structures such as numbers, floats and arrays

```php
$cbor = CBOR::encode('PubNub'); // 665075624E7562

$pi = CBOR::decode('FB40091EB851EB851F') // float(3.14)

```

### Tests
All test cases was validated and double checked using official CBOR converter which can be found at http://cbor.me/

Created by PubNub on MIT license
