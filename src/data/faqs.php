<?php
/**
 * The two FAQ groups: the main marketing FAQ and the support FAQ.
 */

declare(strict_types=1);

return [
    'main' => [
        [
            'q' => 'How does pricing work?',
            'a' => 'There are no fixed packages. We learn what you need, scope it properly, then send a clear, detailed quote — with no obligation to go ahead.',
        ],
        [
            'q' => "What's included in hosting?",
            'a' => 'Fast UK-based hosting with SSL, regular backups, monitoring and updates handled for you. You never need to think about it.',
        ],
        [
            'q' => 'Do you offer ongoing support and updates?',
            'a' => 'Yes. We handle content changes, tweaks and fixes on an ongoing basis — just raise a ticket and we get on it.',
        ],
        [
            'q' => 'Can you take over an existing website?',
            'a' => 'Often, yes. We can migrate, host and maintain most existing sites. Get in touch and we will take a look.',
        ],
        [
            'q' => 'Do you register domains and set up email?',
            'a' => 'We can register and manage your domains and set up professional email on your own domain — all in one place.',
        ],
        [
            'q' => 'How long does a project take?',
            'a' => 'It depends on scope. A simple site can be a couple of weeks; larger apps take longer. Your quote includes a realistic timeline.',
        ],
    ],

    'support' => [
        [
            'q'    => 'How do I set up my email on my phone or computer?',
            'a'    => "We've written a simple step-by-step guide for iPhone, iPad, Android, Outlook and Mac.",
            'link' => ['href' => '/email-setup', 'label' => 'Read the email setup guide'],
        ],
        [
            'q' => 'How quickly will you respond to a ticket?',
            'a' => 'We aim to acknowledge every ticket the same working day, and prioritise anything affecting a live website or email.',
        ],
        [
            'q' => 'What counts as support vs a new project?',
            'a' => 'Fixes, small content updates and things that have stopped working are support. Larger new features or redesigns we will quote separately.',
        ],
        [
            'q' => 'Can I call instead of raising a ticket?',
            'a' => 'Yes — for anything urgent call 07899 955432. A ticket helps us track non-urgent jobs, but the phone is always open.',
        ],
        [
            'q' => 'Do you offer ongoing support plans?',
            'a' => 'We can set up a monthly support retainer for regular updates and priority response — just ask and we will tailor one to you.',
        ],
    ],
];
