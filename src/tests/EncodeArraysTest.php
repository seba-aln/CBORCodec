<?php

declare(strict_types=1);

namespace PubNub\CborCodec\Tests;

use PHPUnit\Framework\TestCase;
use PubNub\CborCodec\CBOR;

class EncodeArraysTest extends TestCase
{
    public function arrays()
    {
        return [
            [ '83010203', [ 1, 2, 3 ] ],
            [ '83416141624163', [ 'a','b','c' ] ],
            [ '831A00BC614EFB4028B0FCB4F1E4B4483132333435363738', [ 12345678, 12.345678, '12345678' ] ],
            [ '81F6', [ null ] ],
            [ '83F6F6F6', [ null, null, null ] ],
            [
                '990178414A416141764161417341634172416941704174412C4120416941704168416F416E4165412C41204161416E41644'
                . '172416F41694164412C41204172417541624179412C41204170417941744168416F416E4120417041654172416C412041614'
                . '16E41644120415041484150412E4149416E4169417441694161416C4169417A41654120415041754162414E4175416241204'
                . '17741694174416841204174416841654120416E416541774120415041754162414E41754162412041734179416E417441614'
                . '178412C4120416741724161416241204179416F417541204141415041494120416B416541794173412E415041754162416C4'
                . '16941734168412041734179416E417441614178412C412041734165416C416541634174412041614120416341684161416E4'
                . '16E4165416C412C412041734165416E4164412041614120416D416541734173416141674165412C412041734165416E41644'
                . '1204161412041624175416E416341684120416F416641204164416141744161412E4131412E4138416B41204169417341204'
                . '16141204168416141724164412D4163416F4164416541644120416C4169416D41694174412C41204163416F416D417041724'
                . '165417341734165417341204164416F4177416E41204174416F4120417341694167416E416C4165412041644161417441614'
                . '16741724161416D4165416641664169416341694165416E4174416C4179412041734165416E41644169416E4167412041734'
                . '16D4161416C416C41204161416D416F4175416E417441734120416F416641204164416141744161417441684172416F41754'
                . '167416841204169416E41664172416141734174417241754163417441754172416541204170416C4161416E416E416541644'
                . '1204174416F412041684161416E4164416C416541204161416C416C412041744168416541204164416141744161415241654'
                . '1644175416E41644161416E41634179412C4120416841694167416841204161417641614169416C416141624169416C41694'
                . '17441794121',
                [
                    'J','a','v','a','s','c','r','i','p','t',',',' ','i','p','h','o','n','e',',',' ','a','n','d','r','o',
                    'i','d',',',' ','r','u','b','y',',',' ','p','y','t','h','o','n',' ','p','e','r','l',' ','a','n','d',
                    ' ','P','H','P','.','I','n','i','t','i','a','l','i','z','e',' ','P','u','b','N','u','b',' ','w','i',
                    't','h',' ','t','h','e',' ','n','e','w',' ','P','u','b','N','u','b',' ','s','y','n','t','a','x',',',
                    ' ','g','r','a','b',' ','y','o','u',' ','A','P','I',' ','k','e','y','s','.','P','u','b','l','i','s',
                    'h',' ','s','y','n','t','a','x',',',' ','s','e','l','e','c','t',' ','a',' ','c','h','a','n','n','e',
                    'l',',',' ','s','e','n','d',' ','a',' ','m','e','s','s','a','g','e',',',' ','s','e','n','d',' ','a',
                    ' ','b','u','n','c','h',' ','o','f',' ','d','a','t','a','.','1','.','8','k',' ','i','s',' ','a',' ',
                    'h','a','r','d','-','c','o','d','e','d',' ','l','i','m','i','t',',',' ','c','o','m','p','r','e','s',
                    's','e','s',' ','d','o','w','n',' ','t','o',' ','s','i','g','n','l','e',' ','d','a','t','a','g','r',
                    'a','m','e','f','f','i','c','i','e','n','t','l','y',' ','s','e','n','d','i','n','g',' ','s','m','a',
                    'l','l',' ','a','m','o','u','n','t','s',' ','o','f',' ','d','a','t','a','t','h','r','o','u','g','h',
                    ' ','i','n','f','r','a','s','t','r','u','c','t','u','r','e',' ','p','l','a','n','n','e','d',' ','t',
                    'o',' ','h','a','n','d','l','e',' ','a','l','l',' ','t','h','e',' ','d','a','t','a','R','e','d','u',
                    'n','d','a','n','c','y',',',' ','h','i','g','h',' ','a','v','a','i','l','a','b','i','l','i','t','y',
                    '!'
                ]
            ]
        ];
    }

    /**
     * @dataProvider arrays
     */
    public function testEncodeArrays($expected, $input)
    {
        $decoded = CBOR::encode($input, CBOR::TYPE_BYTE_STRING);
        $this->assertEquals($expected, $decoded);
    }
}
