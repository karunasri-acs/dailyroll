<?php
/**
 * Build a configuration array to pass to `Hybridauth\Hybridauth`
 */

$config = [
  /**
   * Set the Authorization callback URL to https://path/to/hybridauth/examples/example_06/callback.php.
   * Understandably, you need to replace 'path/to/hybridauth' with the real path to this script.
   */
  'callback' => 'https://dailyroll.org/hybridauth/callback.php',
  'callback1' => 'https://votersurvey.net/hybridauth/googlecallback.php',
  
  'providers' => [
		'Twitter' => [
		  'enabled' => true,
		  'keys' => [
			'key' => '8l0xO1HuNe2Do5UCg7GrVd5Hf',
			'secret' => 'DJZrjSwA0wzAAwlpxzo7yXdIO1u474dbq8soUZddKY6khyLwRc',
		  ],
		],
		'LinkedIn' => [
		  'enabled' => true,
		  'keys' => [
			'id' => '780pwncg8hnaxz',
			'secret' => '8qjlv1KsEBGdLZJV',
		  ],
		],
		'Facebook' => [
		  'enabled' => true,
		  'keys' => [
			'id' => '280810939847909',
			'secret' => '68a1568489fc4162d992c63819b08e1c',
		  ],
		],
		'Google' => [
            'enabled' => true,
            'keys' => [
                'id'     => '169022238364-4nlek7a7r28hg295slr2st8gp8av8obc.apps.googleusercontent.com',
                'secret' => 'Ew9dproB-8lLbtOe095orl7g',
            ],
        ],
  ],
];
