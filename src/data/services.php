<?php
/**
 * The eight services. `featured` => the "Most requested" peach cards.
 * `icon` keys map to inline SVGs rendered in sections/services.php.
 */

declare(strict_types=1);

return [
    [
        'id'       => 'svc-web',
        'icon'     => 'web',
        'title'    => 'Website Design & Development',
        'desc'     => 'Bespoke, responsive websites designed around your brand and built to perform.',
        'featured' => true,
    ],
    [
        'id'       => 'svc-hosting',
        'icon'     => 'hosting',
        'title'    => 'Hosting',
        'desc'     => 'Fast, secure UK hosting with SSL, backups and monitoring — all handled for you.',
        'featured' => true,
    ],
    [
        'id'       => 'svc-domains',
        'icon'     => 'domains',
        'title'    => 'Domain Registration',
        'desc'     => 'Register and manage your domains in one place, with none of the guesswork.',
        'featured' => true,
    ],
    [
        'id'       => 'svc-email',
        'icon'     => 'email',
        'title'    => 'Email Hosting',
        'desc'     => 'Professional email on your own domain, set up and maintained properly.',
        'featured' => true,
    ],
    [
        'id'       => 'svc-software',
        'icon'     => 'software',
        'title'    => 'Software Development',
        'desc'     => 'Custom software and tools built to fit exactly how your business works.',
        'featured' => false,
    ],
    [
        'id'       => 'svc-webapp',
        'icon'     => 'webapp',
        'title'    => 'Web Application Development',
        'desc'     => 'Interactive web apps, dashboards and client portals built for the browser.',
        'featured' => false,
    ],
    [
        'id'       => 'svc-fullstack',
        'icon'     => 'fullstack',
        'title'    => 'Full-Stack Engineering',
        'desc'     => 'Front to back — interface, APIs, databases and infrastructure, joined up.',
        'featured' => false,
    ],
    [
        'id'       => 'svc-support',
        'icon'     => 'support',
        'title'    => 'Support & Website Updates',
        'desc'     => 'Ongoing support, fixes and content updates whenever you need them.',
        'featured' => false,
    ],
];
