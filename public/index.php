<?php
/**
 * Home page — composes the section partials.
 */

declare(strict_types=1);

require __DIR__ . '/../src/config.php';

// Load content data once and share with the sections.
$services     = load_data('services');
$faqGroups    = load_data('faqs');
$faqs         = $faqGroups['main'] ?? [];
$supportFaqs  = $faqGroups['support'] ?? [];
$testimonials = load_data('testimonials');

// ---- Structured data (JSON-LD) ----
$offerCatalog = array_map(static fn(array $s): array => [
    '@type' => 'Offer',
    'itemOffered' => ['@type' => 'Service', 'name' => $s['title'], 'description' => $s['desc']],
], $services);

$page = [
    'title'       => 'Web design, software & hosting',
    'description' => 'Nospario Digital is a small UK studio helping small businesses and start-ups design, build, host and support their websites and software — all under one roof.',
    'path'        => '/',
    'og_type'     => 'website',
    'jsonld'      => [
        [
            '@context'    => 'https://schema.org',
            '@type'       => 'ProfessionalService',
            'name'        => SITE_NAME,
            'url'         => SITE_URL,
            'logo'        => url('assets/logos/nospario-logo.svg'),
            'image'       => url('assets/img/og-image.jpg'),
            'email'       => CONTACT_EMAIL,
            'telephone'   => CONTACT_PHONE_INTL,
            'description' => 'Website design & development, software development, hosting, domain registration, email hosting and ongoing support for small businesses and start-ups.',
            'areaServed'  => ['@type' => 'Country', 'name' => 'GB'],
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name'  => 'Services',
                'itemListElement' => $offerCatalog,
            ],
        ],
        [
            '@context' => 'https://schema.org',
            '@type'    => 'WebSite',
            'name'     => SITE_NAME,
            'url'      => SITE_URL,
        ],
    ],
];

require __DIR__ . '/../src/partials/head.php';
require __DIR__ . '/../src/partials/header.php';

require __DIR__ . '/../src/sections/hero.php';
require __DIR__ . '/../src/sections/services.php';
require __DIR__ . '/../src/sections/about.php';
require __DIR__ . '/../src/sections/pricing.php';
require __DIR__ . '/../src/sections/testimonials.php';
require __DIR__ . '/../src/sections/faq.php';
require __DIR__ . '/../src/sections/contact.php';
require __DIR__ . '/../src/sections/support.php';

require __DIR__ . '/../src/partials/footer.php';
