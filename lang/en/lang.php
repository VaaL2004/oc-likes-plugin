<?php return [
    'plugin' => [
        'name' => 'Likes',
        'description' => 'Provides Like / Dislike buttons',
        'like' => 'Like',
        'dislike' => 'Dislike',
        'components' => [
            'likebuttons' => [
                'title' => 'Like / Dislike Buttons',
                'description' => 'Provides Like / Dislike buttons on frontend',
                'likeable_type' => 'Object type for Like (model namespace fullpath)',
                'likeable_id' => 'Object ID to Like',
                'unregistred' => 'Please enter your profile to be able to rate',
            ],
        ],
    ],
];