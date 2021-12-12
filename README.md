Simple and fast coder/decoder for CBOR


### Examples:
It's extremely simple to encode and decode basic PHP structures such as numbers, floats and arrays

```php
$cbor = CBOR::encode('Hello world'); // 6B48656C6C6F20776F726C64

$pi = CBOR::decode('FB40091EB851EB851F') // float(3.14)

```

### Tests
All test cases was validated and double checked using official CBOR converter which can be found at http://cbor.me/

Created on MIT license
