<?php

return [
	'mode'                  => 'utf-8',
    'format'                => 'A4-L',
    'author'                => '',
	'subject'               => '',
	'keywords'              => '',
	'creator'               => 'Laravel Pdf',
	'display_mode'          => 'fullpage',
	'tempDir'               => base_path('../temp/'),
	'font_path' => base_path('resources/fonts/'),
    'font_data' => [
        'bangla' => [
            'R'  => 'f1V41537441629.ttf',    // regular font
            'B'  => 'f1V41537441629.ttf',       // optional: bold font
            'I'  => 'f1V41537441629.ttf',     // optional: italic font
            'BI' => 'f1V41537441629.ttf', // optional: bold-italic font
            'useOTL' => 0xFF,   
            'useKashida' => 75, 
        ]

        // ...add as many as you want.
    ]
];
