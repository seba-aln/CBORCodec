<?php

declare(strict_types=1);

namespace PubNub\CborCodec;

use PubNub\CborCodec\Exceptions;

class CBOR
{
    private const TYPE_MASK         = 0b11100000;
    private const ADDITIONAL_MASK   = 0b00011111;

    public const TYPE_UNSIGNED_INT = 0b00000000;
    public const TYPE_NEGATIVE_INT = 0b00100000;
    public const TYPE_BYTE_STRING  = 0b01000000;
    public const TYPE_TEXT_STRING  = 0b01100000;
    public const TYPE_ARRAY        = 0b10000000;
    public const TYPE_HASHMAP      = 0b10100000;
    public const TYPE_TAG          = 0b11000000;
    public const TYPE_FLOAT        = 0b11100000;

    private const ADDITIONAL_LENGTH_1B = 24;
    private const ADDITIONAL_LENGTH_2B = 25;
    private const ADDITIONAL_LENGTH_4B = 26;
    private const ADDITIONAL_LENGTH_8B = 27;

    private const ADDITIONAL_TYPE_INDEFINITE = 31;

    private const INDEFINITE_BREAK = 0b11111111;

    private static $additionalLength = [
        self::ADDITIONAL_LENGTH_1B,
        self::ADDITIONAL_LENGTH_2B,
        self::ADDITIONAL_LENGTH_4B,
        self::ADDITIONAL_LENGTH_8B,
    ];

    private static $additionalLengthBytes = [
        self::ADDITIONAL_LENGTH_1B => 1,
        self::ADDITIONAL_LENGTH_2B => 2,
        self::ADDITIONAL_LENGTH_4B => 4,
        self::ADDITIONAL_LENGTH_8B => 8,
    ];

    private const SIMPLE_VALUE_FALSE    = 'F4';
    private const SIMPLE_VALUE_TRUE     = 'F5';
    private const SIMPLE_VALUE_NULL     = 'F6';
    private const SIMPLE_VALUE_UNDEF    = 'F7';

    private static $simpleValues = [
        self::SIMPLE_VALUE_FALSE => false,
        self::SIMPLE_VALUE_TRUE => true,
        self::SIMPLE_VALUE_NULL => null,
        self::SIMPLE_VALUE_UNDEF => null
    ];

    /**
     * Decode incoming hexadecimal string of data and outputing decoded values
     *
     * @param string $value
     *
     * @return mixed
     * @throws \Exception
     */
    public static function decode($value)
    {
        $value = self::sanitizeInput($value);
        $data = str_split($value, 2);
        return self::parseData($data);
    }

    private static function parseData(&$data)
    {
        $byte = array_shift($data);

        if (array_key_exists($byte, self::$simpleValues)) {
            return self::$simpleValues[$byte];
        }

        $bits = bindec(str_pad(base_convert($byte, 16, 2), 8, '0', STR_PAD_LEFT));


        $type = $bits & self::TYPE_MASK;
        $additional = $bits & self::ADDITIONAL_MASK;


        switch ($type) {
            case self::TYPE_NEGATIVE_INT:
            case self::TYPE_UNSIGNED_INT:
                if (in_array($additional, self::$additionalLength)) {
                    $value = hexdec(
                        self::getData($data, self::$additionalLengthBytes[$additional])
                    );
                } else {
                    $value = $additional;
                }
                if ($type === self::TYPE_NEGATIVE_INT) {
                    $value = -1 - $value;
                }
                return $value;
            case self::TYPE_FLOAT:
                if ($additional <= 23) {
                    return $additional;
                } elseif ($additional === self::ADDITIONAL_LENGTH_1B) {
                    return self::getData($data);
                } else {
                    return self::decodeFloat(
                        self::getData($data, self::$additionalLengthBytes[$additional]),
                        $additional
                    );
                }

            case self::TYPE_BYTE_STRING:
            case self::TYPE_TEXT_STRING:
                if (in_array($additional, self::$additionalLength)) {
                    $length = hexdec(self::getData($data, self::$additionalLengthBytes[$additional]));
                    $result =  hex2bin(self::getData($data, $length));
                } elseif ($additional == self::ADDITIONAL_TYPE_INDEFINITE) {
                    $result =  hex2bin(self::getIndefiniteData($data));
                } else {
                    $result = hex2bin(self::getData($data, $additional));
                }
                return $result;

            case self::TYPE_ARRAY:
                $result = [];
                if (in_array($additional, self::$additionalLength)) {
                    $length = hexdec(self::getData($data, self::$additionalLengthBytes[$additional]));
                } else {
                    $length = $additional;
                }

                for ($i = 0; $i < $length; $i++) {
                    $result[] = self::parseData($data);
                }
                return $result;

            case self::TYPE_HASHMAP:
                $result = [];
                if (in_array($additional, self::$additionalLength)) {
                    $length = hexdec(self::getData($data, self::$additionalLengthBytes[$additional]));
                } else {
                    $length = $additional;
                }

                for ($i = 0; $i < $length; $i++) {
                    $key = self::parseData($data);
                    $val = self::parseData($data);
                    $result[$key] = $val;
                }
                return $result;
            default:
                throw new \Exception(sprintf('Unsupported Type %b', $type));
        }
    }

    private static function decodeFloat($value, $precision)
    {
        $bytes = hexdec($value);
        switch ($precision) {
            case self::ADDITIONAL_LENGTH_2B:
                $sign = ($bytes & 0b1000000000000000) >> 15;
                $exp = ($bytes & 0b0111110000000000) >> 10;
                $mant = $bytes & 0b1111111111;
                if ($exp === 0) {
                    $result = (2 ** -14) * ($mant / 1024);
                } elseif ($exp === 0b11111) {
                    $result = INF;
                } else {
                    $result = (2 ** ($exp - 15)) * (1 + $mant / 1024);
                }
                return ($sign ? -1 : 1) * $result;

            case self::ADDITIONAL_LENGTH_4B:
                $sign = ($bytes >> 31) ? -1 : 1;
                $x = ($bytes & ((1 << 23) - 1)) + (1 << 23) * ($bytes >> 31 | 1);
                $exp = ($bytes >> 23 & 0xFF) - 127;
                return $x * pow(2, $exp - 23) * $sign;

            case self::ADDITIONAL_LENGTH_8B:
                $sign = ($bytes >> 63) ? -1 : 1;
                $exp = ($bytes >> 52) & 0x7ff;

                $mant = $bytes & 0xfffffffffffff;

                if (0 === $exp) {
                    $val = $mant * 2 ** (-(1022 + 52));
                } elseif (0b11111111111 !== $exp) {
                    $val = ($mant + (1 << 52)) * 2 ** ($exp - (1023 + 52));
                } else {
                    $val = 0 === $mant ? INF : NAN;
                }
                return $sign * $val;
        }
    }

    private static function getData(&$data, $bytes = 1)
    {
        $result = null;
        for ($i = 1; $i <= $bytes; $i++) {
            $result .= array_shift($data);
        }
        return (string)$result;
    }

    private static function getIndefiniteData(&$data)
    {
        $result = null;
        do {
            $byte = array_shift($data);
            if (hexdec($byte) == self::INDEFINITE_BREAK) {
                break;
            }
            $result .= $byte;
        } while (!empty($data));
        return (string)$result;
    }

    /**
     * Removes spaces, converts string to upper case and throws exception if input is not a valid heaxadecimal string
     *
     * @param string $value
     *
     * @return string
     */
    private static function sanitizeInput($value)
    {
        $value = strtoupper(str_replace(' ', '', $value));
        if (preg_match('/[^A-F0-9]/', $value)) {
            throw new \Exception('Invalid Input');
        }
        return $value;
    }

    /**
     * Sanitizes the output value so it contains even number of characters and returns it upper cased
     *
     * @param string $value Hexadecimal value to sanitize
     * @param bool $useByteLength Should the length of output be in powers of two (2, 4, 8, 16)
     *
     * @return string
     */
    private static function sanitizeOutput($value, $useByteLength = false)
    {
        $value = strtoupper($value);
        $length = strlen($value);

        if ($useByteLength) {
            if ($length === 1 || $length === 3) {
                $value = '0' . $value;
            } elseif ($length > 4 && $length < 8) {
                $value = str_pad($value, 8, '0', STR_PAD_LEFT);
            } elseif ($length > 8 && $length < 16) {
                $value = str_pad($value, 16, '0', STR_PAD_LEFT);
            }
        } elseif ($length % 2) {
            $value = '0' . $value;
        }

        return $value;
    }

    /**
     * Encodes value to a hexadecimal CBOR string. Because php does not differentiate byte strings and text strings
     * the only way to manipulate output type of strings is to pass a string type (one of CBOR::TYPE_TEXT_STRING and
     * CBOR::TYPE_BYTE_STRING).
     *
     * @param mixed $value
     * @param string $stringType
     *
     * @return string
     * @throws \Exception
     */

    public static function encode($value, $stringType = self::TYPE_TEXT_STRING)
    {
        $result = '';
        switch (gettype($value)) {
            case 'NULL':
                return self::SIMPLE_VALUE_NULL;
            case 'boolean':
                return ($value)
                    ? self::SIMPLE_VALUE_TRUE
                    : self::SIMPLE_VALUE_FALSE;
            case 'integer':
                $type = self::TYPE_UNSIGNED_INT;
                if ($value < 0) {
                    $type = self::TYPE_NEGATIVE_INT;
                    $value = abs($value + 1);
                }
                if ($value <= 23) {
                    $result = self::sanitizeOutput(dechex($type | $value));
                } else {
                    $value = self::sanitizeOutput(dechex($value), true);
                    $lengthHeader = array_flip(self::$additionalLengthBytes)[strlen($value) / 2];
                    $header = self::sanitizeOutput(dechex($type | $lengthHeader));
                    $result = $header . $value;
                }
                break;

            case 'string':
                $type = $stringType;
                $value = self::sanitizeOutput(bin2hex($value));
                $length = strlen($value) / 2;
                $header = '';
                $footer = '';
                if ($length > 0xffffffffffff) {
                    $footer = dechex(self::INDEFINITE_BREAK);
                }
                $header = self::buildHeader($type, $length);
                $result = $header . $value . $footer;
                break;

            case 'double':
                $header = dechex(self::TYPE_FLOAT | self::ADDITIONAL_LENGTH_8B);
                $value = bin2hex(strrev(pack('d', $value)));
                $result = $header . $value;
                break;
            case 'array':
                $length = count($value);

                if (array_keys($value) !== range(0, count($value) - 1)) {
                    $type = self::TYPE_HASHMAP;
                } else {
                    $type = self::TYPE_ARRAY;
                }
                $result = self::buildHeader($type, $length);

                foreach ($value as $key => $element) {
                    if ($type === self::TYPE_HASHMAP) {
                        $result .= self::encode($key, $stringType);
                    }
                    $result .= self::encode($element, $stringType);
                }
                break;
            default:
                throw new Exceptions\UnsupportedTypeException(
                    'Unsupported type passed to encoding: ' . gettype($value)
                );
        }
        return self::sanitizeOutput($result);
    }

    private static function buildHeader($type, $length)
    {
        if ($length > 0xffffffffffff) {
            $header = dechex($type | self::ADDITIONAL_TYPE_INDEFINITE);
            $footer = dechex(self::INDEFINITE_BREAK);
        } elseif ($length > 0xffffffff) {
            $header = dechex($type | self::ADDITIONAL_LENGTH_8B) . self::sanitizeOutput(dechex($length));
        } elseif ($length > 0xffff) {
            $header = dechex($type | self::ADDITIONAL_LENGTH_4B) . self::sanitizeOutput(dechex($length));
        } elseif ($length > 0xff) {
            $header = dechex($type | self::ADDITIONAL_LENGTH_2B) . self::sanitizeOutput(dechex($length));
        } elseif ($length > 23) {
            $header = dechex($type | self::ADDITIONAL_LENGTH_1B) . self::sanitizeOutput(dechex($length));
        } else {
            $header = dechex($type | $length);
        }
        return $header;
    }
}
