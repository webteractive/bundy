<?php

return [

    // Schedules
    'schedule' => [
        'stored' => 'Your schedules has been saved.',
        'requested' => 'Your request for change schedule has been sent.',
        'approved' => 'Change schedule request has been approved.',
        'declined' => 'Change schedule request has been declined.',
    ],

    // Profile
    'profile' => [
        'updated' => 'Your profile has been updated successfully.',
        'media' => [
            'updated' => 'Your profile :collection has been updated successfully.'
        ]
    ],

    // Working Remote
    'working_remote' => [
        'updated' => 'Your reason for working remote has been saved successfully and awaiting approval from the Admin.'
    ],

    // Scrum
    'scrum' => [
        'posted' => 'Your scrum has been posted successfully.'
    ],

    // Password
    'password' => [
        'changed' => 'Your password has been updated successfully.',
        'reset' => ':name\'s password has been reset successfully. An email has been sent to :name that contains the temporary password.'
    ],

    // Admin
    'admin' => [
        // Users
        'user' => [
            'created' => 'New user :name has been created successfully.',
            'updated' => ':name\'s details has been update successfully.',
            'status' => [
                'resigned' => ':name\'s status has been set to resigned successfully.',
                'suspended' => ':name\'s status has been set to suspended successfully.',
                'active' => ':name\'s status has been set to active successfully.',
            ],
        ]
    ],

    // Notification
    'notification' => [
        'schedule_request' => [
            'subject' => [
                'new' => 'New :request',
                'approved' => 'Change schedule request approved',
                'rejected' => 'Change schedule request rejected',
            ],
            'message' => [
                'new' => 'A new :request has been filed by :name awaiting your approval. The reason for this request is ":reason".',
                'updated' => 'The change schedule request that you did on :date has been :status.:reason',
            ]
        ]
    ]
];
