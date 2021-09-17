<?php

namespace PubNub\CborCodec\tests\Traits;

trait DataProviders {

    public function primitives(): array
    {
        return [
            ['F4', false],
            ['F5', true],
            ['F6', null],
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

    public function halfPrecision()
    {
        return [
            ['F93C00', 1.0],
            ['F93555', 0.333251953125],
            ['F9EC00', -4096],
        ];
    }

    public function singlePrecision()
    {
        return [
            ['FA47D9F95E', 111602.734375],
            ['FAC4027000', -521.75],
            ['FA457F9000', 4089],
            ['FA0002D7F5', 6.00804264307E-39],
            ['FA47D9F95E', 111602.734375],
        ];
    }

    public function doublePrecision()
    {
        return [
            ['FB40091EB851EB851F', 3.14],
            ['FB40091EB851EB8DE1', 3.1400000000009958],
            ['FB4000147AE147AE14', 2.01],
            ['FBC0240083126E978D', -10.001],
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
            [ '4A507562F09F93A24E7562', 'Pub📢Nub']
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
            [ '6A507562F09F93A24E7562', 'Pub📢Nub'],
            [
                '7901904A6176617363726970742C206970686F6E652C20616E64726F69642C20727562792C20707974686F6E207065726C20616E64205048502E0D0A0D0A496E697469616C697A65205075624E7562207769746820746865206E6577205075624E75622073796E7461782C206772616220796F7520415049206B6579732E0D0A0D0A5075626C6973682073796E7461782C2073656C6563742061206368616E6E656C2C2073656E642061206D6573736167652C2073656E6420612062756E6368206F6620646174612E0D0A0D0A312E386B206973206120686172642D636F646564206C696D69742C20636F6D7072657373657320646F776E20746F207369676E6C6520646174616772616D0D0A0D0A656666696369656E746C792073656E64696E6720736D616C6C20616D6F756E7473206F6620646174610D0A0D0A7468726F75676820696E66726173747275637475726520706C616E6E656420746F2068616E646C6520616C6C2074686520646174610D0A0D0A526564756E64616E63792C206869676820617661696C6162696C69747921',
                "Javascript, iphone, android, ruby, python perl and PHP.\r\n\r\nInitialize PubNub with the new PubNub syntax, grab you API keys.\r\n\r\nPublish syntax, select a channel, send a message, send a bunch of data.\r\n\r\n1.8k is a hard-coded limit, compresses down to signle datagram\r\n\r\nefficiently sending small amounts of data\r\n\r\nthrough infrastructure planned to handle all the data\r\n\r\nRedundancy, high availability!"
            ]
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
                '990178414A416141764161417341634172416941704174412C4120416941704168416F416E4165412C41204161416E41644172416F41694164412C41204172417541624179412C41204170417941744168416F416E4120417041654172416C41204161416E41644120415041484150412E4149416E4169417441694161416C4169417A41654120415041754162414E417541624120417741694174416841204174416841654120416E416541774120415041754162414E41754162412041734179416E417441614178412C4120416741724161416241204179416F417541204141415041494120416B416541794173412E415041754162416C416941734168412041734179416E417441614178412C412041734165416C416541634174412041614120416341684161416E416E4165416C412C412041734165416E4164412041614120416D416541734173416141674165412C412041734165416E416441204161412041624175416E416341684120416F416641204164416141744161412E4131412E4138416B4120416941734120416141204168416141724164412D4163416F4164416541644120416C4169416D41694174412C41204163416F416D417041724165417341734165417341204164416F4177416E41204174416F4120417341694167416E416C416541204164416141744161416741724161416D4165416641664169416341694165416E4174416C4179412041734165416E41644169416E416741204173416D4161416C416C41204161416D416F4175416E417441734120416F416641204164416141744161417441684172416F41754167416841204169416E41664172416141734174417241754163417441754172416541204170416C4161416E416E4165416441204174416F412041684161416E4164416C416541204161416C416C4120417441684165412041644161417441614152416541644175416E41644161416E41634179412C4120416841694167416841204161417641614169416C416141624169416C4169417441794121',
                ['J','a','v','a','s','c','r','i','p','t',',',' ','i','p','h','o','n','e',',',' ','a','n','d','r','o','i','d',',',' ','r','u','b','y',',',' ','p','y','t','h','o','n',' ','p','e','r','l',' ','a','n','d',' ','P','H','P','.','I','n','i','t','i','a','l','i','z','e',' ','P','u','b','N','u','b',' ','w','i','t','h',' ','t','h','e',' ','n','e','w',' ','P','u','b','N','u','b',' ','s','y','n','t','a','x',',',' ','g','r','a','b',' ','y','o','u',' ','A','P','I',' ','k','e','y','s','.','P','u','b','l','i','s','h',' ','s','y','n','t','a','x',',',' ','s','e','l','e','c','t',' ','a',' ','c','h','a','n','n','e','l',',',' ','s','e','n','d',' ','a',' ','m','e','s','s','a','g','e',',',' ','s','e','n','d',' ','a',' ','b','u','n','c','h',' ','o','f',' ','d','a','t','a','.','1','.','8','k',' ','i','s',' ','a',' ','h','a','r','d','-','c','o','d','e','d',' ','l','i','m','i','t',',',' ','c','o','m','p','r','e','s','s','e','s',' ','d','o','w','n',' ','t','o',' ','s','i','g','n','l','e',' ','d','a','t','a','g','r','a','m','e','f','f','i','c','i','e','n','t','l','y',' ','s','e','n','d','i','n','g',' ','s','m','a','l','l',' ','a','m','o','u','n','t','s',' ','o','f',' ','d','a','t','a','t','h','r','o','u','g','h',' ','i','n','f','r','a','s','t','r','u','c','t','u','r','e',' ','p','l','a','n','n','e','d',' ','t','o',' ','h','a','n','d','l','e',' ','a','l','l',' ','t','h','e',' ','d','a','t','a','R','e','d','u','n','d','a','n','c','y',',',' ','h','i','g','h',' ','a','v','a','i','l','a','b','i','l','i','t','y','!']
            ]
        ];
    }

    public function hashMaps()
    {
        return [
            [ 'A1465075624E75624652756C657A21', ['PubNub' => 'Rulez!'] ],
            [
                'A1465075624E7562A44C64656C697665727954696D65F93400424841F54A7573657253746174757344F09F98830183010203',
                [ 'PubNub' => [ 'deliveryTime' => 0.25, 'HA' => true, 'userStatus' => '😃', 1 => [ 1, 2, 3 ] ] ]
            ],
            [
                'A20000613000', [0 => 0, '0' => 0 ]
            ],
            [
                'B864626130636120306261316361203162613263612032626133636120336261346361203462613563612035626136636120366261376361203762613863612038626139636120396262306362203062623163622031626232636220326262336362203362623463622034626235636220356262366362203662623763622037626238636220386262396362203962633063632030626331636320316263326363203262633363632033626334636320346263356363203562633663632036626337636320376263386363203862633963632039626430636420306264316364203162643263642032626433636420336264346364203462643563642035626436636420366264376364203762643863642038626439636420396265306365203062653163652031626532636520326265336365203362653463652034626535636520356265366365203662653763652037626538636520386265396365203962663063662030626631636620316266326366203262663363662033626634636620346266356366203562663663662036626637636620376266386366203862663963662039626730636720306267316367203162673263672032626733636720336267346367203462673563672035626736636720366267376367203762673863672038626739636720396268306368203062683163682031626832636820326268336368203362683463682034626835636820356268366368203662683763682037626838636820386268396368203962693063692030626931636920316269326369203262693363692033626934636920346269356369203562693663692036626937636920376269386369203862693963692039626A30636A2030626A31636A2031626A32636A2032626A33636A2033626A34636A2034626A35636A2035626A36636A2036626A37636A2037626A38636A2038626A39636A2039',
                [ 'a0' => 'a 0','a1' => 'a 1','a2' => 'a 2','a3' => 'a 3','a4' => 'a 4','a5' => 'a 5','a6' => 'a 6','a7' => 'a 7','a8' => 'a 8','a9' => 'a 9','b0' => 'b 0','b1' => 'b 1','b2' => 'b 2','b3' => 'b 3','b4' => 'b 4','b5' => 'b 5','b6' => 'b 6','b7' => 'b 7','b8' => 'b 8','b9' => 'b 9','c0' => 'c 0','c1' => 'c 1','c2' => 'c 2','c3' => 'c 3','c4' => 'c 4','c5' => 'c 5','c6' => 'c 6','c7' => 'c 7','c8' => 'c 8','c9' => 'c 9','d0' => 'd 0','d1' => 'd 1','d2' => 'd 2','d3' => 'd 3','d4' => 'd 4','d5' => 'd 5','d6' => 'd 6','d7' => 'd 7','d8' => 'd 8','d9' => 'd 9','e0' => 'e 0','e1' => 'e 1','e2' => 'e 2','e3' => 'e 3','e4' => 'e 4','e5' => 'e 5','e6' => 'e 6','e7' => 'e 7','e8' => 'e 8','e9' => 'e 9','f0' => 'f 0','f1' => 'f 1','f2' => 'f 2','f3' => 'f 3','f4' => 'f 4','f5' => 'f 5','f6' => 'f 6','f7' => 'f 7','f8' => 'f 8','f9' => 'f 9','g0' => 'g 0','g1' => 'g 1','g2' => 'g 2','g3' => 'g 3','g4' => 'g 4','g5' => 'g 5','g6' => 'g 6','g7' => 'g 7','g8' => 'g 8','g9' => 'g 9','h0' => 'h 0','h1' => 'h 1','h2' => 'h 2','h3' => 'h 3','h4' => 'h 4','h5' => 'h 5','h6' => 'h 6','h7' => 'h 7','h8' => 'h 8','h9' => 'h 9','i0' => 'i 0','i1' => 'i 1','i2' => 'i 2','i3' => 'i 3','i4' => 'i 4','i5' => 'i 5','i6' => 'i 6','i7' => 'i 7','i8' => 'i 8','i9' => 'i 9','j0' => 'j 0','j1' => 'j 1','j2' => 'j 2','j3' => 'j 3','j4' => 'j 4','j5' => 'j 5','j6' => 'j 6','j7' => 'j 7','j8' => 'j 8','j9' => 'j 9' ]
            ]
        ];
    }
}