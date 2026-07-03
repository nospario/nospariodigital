<?php
/**
 * Privacy & Cookie Policy content: prose sections + the cookie table.
 * Cookie tag classes map to .pill--on / .pill--opt in the stylesheet.
 */

declare(strict_types=1);

return [
    'last_updated' => '18 June 2026',

    'sections' => [
        [
            'id'      => 'who-we-are',
            'heading' => 'Who we are',
            'paras'   => [
                'Nospario Digital is a small digital studio based in the UK, providing website design and development, software development, hosting, domain registration, email hosting and ongoing support to small businesses and start-ups.',
                'For the purposes of data protection law, Nospario Digital is the data controller for personal information collected through this website and the services we provide.',
            ],
            'items'   => [],
        ],
        [
            'id'      => 'information-we-collect',
            'heading' => 'Information we collect',
            'paras'   => ['We only collect information that we genuinely need. Depending on how you interact with us, this may include:'],
            'items'   => [
                ['label' => 'Contact details — ', 'text' => 'your name, email address, phone number and business name when you submit an enquiry or support ticket.'],
                ['label' => 'Project information — ', 'text' => 'details you share about your business, goals and requirements so we can prepare a quote.'],
                ['label' => 'Technical data — ', 'text' => 'IP address, browser type, device information and pages visited, collected automatically as you browse.'],
                ['label' => 'Service data — ', 'text' => 'information relating to websites, hosting and email we manage on your behalf as a client.'],
            ],
        ],
        [
            'id'      => 'how-we-use',
            'heading' => 'How we use your information',
            'paras'   => ['We use the information we collect to:'],
            'items'   => [
                ['label' => 'Respond to enquiries — ', 'text' => 'to reply to your messages, prepare quotes and discuss your project.'],
                ['label' => 'Provide our services — ', 'text' => 'to deliver, host, maintain and support the websites, software and email we build for you.'],
                ['label' => 'Handle support — ', 'text' => 'to log, track and resolve support tickets you raise.'],
                ['label' => 'Improve our website — ', 'text' => 'to understand how the site is used and make it work better.'],
                ['label' => 'Meet legal obligations — ', 'text' => 'for billing, accounting and compliance where required by law.'],
            ],
        ],
        [
            'id'      => 'legal-basis',
            'heading' => 'Our legal basis for processing',
            'paras'   => [
                'We rely on legitimate interests to respond to enquiries and run our business, on the performance of a contract to deliver services to our clients, on consent for non-essential cookies and marketing, and on legal obligation where we are required to keep records.',
                'You can withdraw consent at any time where we rely on it — for example, by adjusting your cookie settings or asking us to stop contacting you.',
            ],
            'items'   => [],
        ],
        [
            'id'      => 'sharing',
            'heading' => 'Sharing your information',
            'paras'   => ['We do not sell your personal information. We only share it where necessary to run our services, with trusted providers such as hosting and infrastructure partners, email providers and domain registrars. These partners process data on our behalf under appropriate agreements. We may also disclose information where required by law.'],
            'items'   => [],
        ],
        [
            'id'      => 'retention',
            'heading' => 'How long we keep it',
            'paras'   => ['We keep personal information only for as long as we need it for the purposes set out above, or as required by law. Enquiry data that does not lead to a project is deleted within a reasonable period. Client records are kept for the duration of our relationship and for any period required for legal and accounting purposes afterwards.'],
            'items'   => [],
        ],
        [
            'id'      => 'your-rights',
            'heading' => 'Your rights',
            'paras'   => ['Under UK data protection law you have the right to:'],
            'items'   => [
                ['label' => 'Access — ', 'text' => 'request a copy of the personal information we hold about you.'],
                ['label' => 'Rectification — ', 'text' => 'ask us to correct information that is inaccurate or incomplete.'],
                ['label' => 'Erasure — ', 'text' => 'ask us to delete your personal information in certain circumstances.'],
                ['label' => 'Object & restrict — ', 'text' => 'object to or restrict how we process your information.'],
                ['label' => 'Portability — ', 'text' => 'request your data in a portable, machine-readable format.'],
            ],
        ],
        [
            'id'      => 'security',
            'heading' => 'How we protect your information',
            'paras'   => ['We take security seriously. We use secure UK-based hosting, SSL encryption, access controls and regular backups to keep your information safe. While no system can be completely secure, we work hard to protect your data and to respond quickly if anything goes wrong.'],
            'items'   => [],
        ],
        [
            'id'      => 'cookies',
            'heading' => 'How we use cookies',
            'paras'   => [
                'This website uses cookies and similar technologies to make the site work, to remember your preferences and to understand how the site is used.',
                'When you first visit, you can choose which non-essential cookies to allow. Essential cookies are always on because the site cannot function properly without them.',
            ],
            'items'   => [],
        ],
    ],

    'cookies' => [
        ['name' => 'Essential',  'tag' => 'Always on', 'tag_class' => 'pill--on',  'desc' => 'Required for the website to work — they handle things like page navigation and security. The site cannot function properly without these.'],
        ['name' => 'Preference', 'tag' => 'Optional',  'tag_class' => 'pill--opt', 'desc' => 'Remember choices you make, such as settings and preferences, to give you a smoother experience on return visits.'],
        ['name' => 'Analytics',  'tag' => 'Optional',  'tag_class' => 'pill--opt', 'desc' => 'Help us understand how visitors use the site — which pages are visited and how people get around — so we can improve it. This data is aggregated.'],
        ['name' => 'Marketing',  'tag' => 'Optional',  'tag_class' => 'pill--opt', 'desc' => 'Used only if enabled, to measure the effectiveness of any campaigns. We do not use marketing cookies without your consent.'],
    ],
];
