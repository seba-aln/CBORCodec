<?php

namespace PubNub\CborCodec\tests\Traits;

trait DataProviders {

    public function primitives(): array
    {
        return [
            ['F4', false],
            ['F5', true],
            ['F6', null],
            ['F7', null], // should be undefined
        ];
    }

    public function positiveIntegers(): array
    {
        return [
            ['00', 0],
            ['01', 1],
            ['13', 19],
            ['181F', 31],
            ['190100', 256],
            ['19FFFF', 65535],
            ['1A00010000', 65536],
            ['1AFFFFFFFF', 4294967295],
        ];
    }

    public function negativeIntegers(): array
    {
        return [
            ['20', -1],
            ['38FF', -256],
            ['390100', -257],
            ['39FFFF', -65536],
            ['3A00010000', -65537],
            ['3AFFFFFFFF', -4294967296],
        ];
    }

    public function floats()
    {
        return [
            ['F93C00', 1.0],
            ['F93555', 0.333251953125],
            ['F9EC00', -4096],
            ['FA47D9F95E', 111602.734375],
            ['FAC4027000', -521.75],
            ['FA457F9000', 4089],
            ['FA0002D7F5', 6.00804264307E-39],
            ['FA47D9F95E', 111602.734375],
            ['FB40091EB851EB851F', 3.14],
            ['FB4000147AE147AE14', 2.01],
            ['FB0000000000000000', 0],
            ['FBc0240083126e978d', -10.001],
        ];
    }

    public function byteStrings()
    {
        return [
            ['4161', 'a'],
            ['43666F6F', 'foo'],
            [
                '581A5A61C5BCC3B3C582C4872067C499C59B6CC485206A61C5BAC584',
                'Zażółć gęślą jaźń',
            ],
            [
                '5823717569636B2062726F776E20666F78206A756D7073206F766572206C617A7920646F67',
                'quick brown fox jumps over lazy dog',
            ],
            ['5818526F6D656F20F09F988D202620F09F9898204A756C696574', 'Romeo 😍 & 😘 Juliet'],
        ];
    }

    public function utf8Strings()
    {
        return [
            ['6161', 'a'],
            ['63666F6F', 'foo'],
            [
                '781A5A61C5BCC3B3C582C4872067C499C59B6CC485206A61C5BAC584',
                'Zażółć gęślą jaźń',
            ],
            [
                '7823717569636B2062726F776E20666F78206A756D7073206F766572206C617A7920646F67',
                'quick brown fox jumps over lazy dog',
            ],
            ['7818526F6D656F20F09F988D202620F09F9898204A756C696574', 'Romeo 😍 & 😘 Juliet'],
        ];
    }

    public function arrays()
    {
        return [
            [ '80', [] ],
            [ '83010203', [ 1, 2, 3 ] ],
            [ '83416141624163', [ 'a','b','c' ] ],
            [ '831A00BC614EFB4028B0FCB4F1E4B4483132333435363738', [ 12345678, 12.345678, '12345678' ] ],
            [ '81F6', [ null ] ],
            [ '83F6F6F6', [ null, null, null ] ],
            [
                '98DD414C416F41724165416D41204169417041734175416D41204164416F416C416F4172412041734169417441204161416D41654174412C41204163416F416E41734165416341744165417441754172412041614164416941704169417341634169416E416741204165416C416941744176412E41204144416F416E41654163412041654175412041764165416C416941744120416C416F4162416F41724176417441694173412C412041764165416E4165416E416141744169417341204165417241614174412041734169417441204161416D4165417442762C422069416E41744165417241644175416D4120416C416941674175416C4161412E4120414E4161416D412041744165416D4170416F41724120416E41654171417541654120417341654164412041744165416C416C41754173412041644169416341744175416D41204173416F41644161416C41654173412E4120414E4161416D41204176416941744161416541204176416E4165417141754165417641204169416E41204164417541694120416541674165417341744161417341204165417541694173416D416F41644120417341654164412041614120417141754161416D412E',
                ['L','o','r','e','m',' ','i','p','s','u','m',' ','d','o','l','o','r',' ','s','i','t',' ','a','m','e','t',',',' ','c','o','n','s','e','c','t','e','t','u','r',' ','a','d','i','p','i','s','c','i','n','g',' ','e','l','i','t','v','.',' ','D','o','n','e','c',' ','e','u',' ','v','e','l','i','t',' ','l','o','b','o','r','v','t','i','s',',',' ','v','e','n','e','n','a','t','i','s',' ','e','r','a','t',' ','s','i','t',' ','a','m','e','t','v,',' i','n','t','e','r','d','u','m',' ','l','i','g','u','l','a','.',' ','N','a','m',' ','t','e','m','p','o','r',' ','n','e','q','u','e',' ','s','e','d',' ','t','e','l','l','u','s',' ','d','i','c','t','u','m',' ','s','o','d','a','l','e','s','.',' ','N','a','m',' ','v','i','t','a','e',' ','v','n','e','q','u','e','v',' ','i','n',' ','d','u','i',' ','e','g','e','s','t','a','s',' ','e','u','i','s','m','o','d',' ','s','e','d',' ','a',' ','q','u','a','m','.']
            ]
        ];
    }

}