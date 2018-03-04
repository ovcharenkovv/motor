<?php

namespace VseTv;

use App\VseTv\ProgrammeTransform;
use FunctionalTester as Tester;

class ProgrammeTransformCest
{

    public function testProgrammeTransformation(Tester $I)
    {

        $results = [
            '<img src="/pic/o0.gif"><img src="/pic/o8.gif">:<img src="/pic/o0.gif"><img src="/pic/o0.gif">',
            'title',
        ];

        $monday = now()->startOfWeek()->format("Y-m-d");

        $expected = [
            [
                'start' => $monday . ' 05:00',
                'title' => 'title',
                'channel_id' => 2,
                'stop' => $monday . ' 05:00'
            ],
        ];

        $I->assertEquals(
            $expected,
            (new ProgrammeTransform($results, 'o0', 2))->getProgramme()
        );
    }

    public function testProgrammeSplitBetweenTwoDays(Tester $I)
    {

        $results = [
            '23:4<img src="/pic/f2.gif">',
            'Д/с "Неразгаданный мир", 8 с. "Предотвратить конец света".',
            '<img src="/pic/f1.gif">1:4<img src="/pic/f2.gif">',
            '"Д/с "Неразгаданный мир", 9 с. "Секреты пиротехники".',
        ];

        $expected = [
            [
                'start' => now()->startOfWeek()->format("Y-m-d") . ' 23:45',
                'title' => 'Д/с "Неразгаданный мир", 8 с. "Предотвратить конец света".',
                'channel_id' => 1,
                'stop' => now()->startOfWeek()->addDay()->format("Y-m-d") . ' 01:45'
            ],
            [
                'start' => now()->startOfWeek()->addDay()->format("Y-m-d") . ' 01:45',
                'title' => '"Д/с "Неразгаданный мир", 9 с. "Секреты пиротехники".',
                'channel_id' => 1,
                'stop' => now()->startOfWeek()->addDay()->format("Y-m-d") . ' 01:45'
            ]

        ];

        $I->assertEquals(
            $expected,
            (new ProgrammeTransform($results, 'f1', 1))->getProgramme()
        );
    }
}
