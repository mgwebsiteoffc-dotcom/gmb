@php
    $brand = 'Untab';
    $baseUrl = rtrim(config('app.url'), '/');
    $seoType   = $seoType ?? 'website';
    $seoTitle  = $seoTitle ?? ($title ?? 'Untab — Google Business Profile Management Platform');
    $seoDesc   = $seoDesc ?? 'Run every Google Business Profile from one dashboard. AI review replies, Google Posts scheduling, local SEO insights, and white-label client reports for agencies and multi-location brands.';
    $seoKeywords = $seoKeywords ?? 'Google Business Profile management, GBP tool, GMB management, local SEO, review management, AI review replies, Google Posts scheduler, multi-location SEO, white-label reports';
    $seoImage  = $seoImage ?? $baseUrl.'/og-image.png';
    $seoUrl    = $seoUrl ?? url()->current();
    $seoRobots = $seoRobots ?? 'index, follow';
    $jsonLd    = $jsonLd ?? [];
@endphp

<title>{{ $seoTitle }}</title>
<meta name="description" content="{{ $seoDesc }}">
<meta name="keywords" content="{{ $seoKeywords }}">
<meta name="robots" content="{{ $seoRobots }}">
<meta name="author" content="{{ $brand }}">
<meta name="theme-color" content="#1a35c8">
<link rel="canonical" href="{{ $seoUrl }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="{{ $seoType }}">
<meta property="og:site_name" content="{{ $brand }}">
<meta property="og:title" content="{{ $seoTitle }}">
<meta property="og:description" content="{{ $seoDesc }}">
<meta property="og:url" content="{{ $seoUrl }}">
<meta property="og:image" content="{{ $seoImage }}">
<meta property="og:locale" content="en_US">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@untab">
<meta name="twitter:creator" content="@untab">
<meta name="twitter:title" content="{{ $seoTitle }}">
<meta name="twitter:description" content="{{ $seoDesc }}">
<meta name="twitter:image" content="{{ $seoImage }}">

<!-- Geo / Local SEO (AEO) -->
<meta name="geo.region" content="US">
<meta name="geo.placename" content="Austin, TX">
<meta name="geo.position" content="30.2672;-97.7431">
<meta name="ICBM" content="30.2672, -97.7431">

<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<link rel="shortcut icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<link rel="apple-touch-icon" href="{{ asset('logo.svg') }}">
<link rel="manifest" href="{{ asset('site.webmanifest') }}">

<!-- Base Organization + WebSite + Application JSON-LD -->
<script type="application/ld+json">
@php
    $baseSchemas = [
        [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $brand,
            'alternateName' => 'Untab Local Growth Platform',
            'url' => $baseUrl,
            'logo' => $baseUrl.'/logo.svg',
            'sameAs' => [
                'https://twitter.com/untab',
                'https://www.linkedin.com/company/untab',
                'https://www.facebook.com/untab',
            ],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => '+1-512-555-0100',
                'contactType' => 'customer support',
                'email' => 'mailto:support@untab.com',
                'areaServed' => 'US',
                'availableLanguage' => ['English'],
            ],
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => '401 Congress Ave, Suite 120',
                'addressLocality' => 'Austin',
                'addressRegion' => 'TX',
                'postalCode' => '78701',
                'addressCountry' => 'US',
            ],
        ],
        [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => $brand,
            'url' => $baseUrl,
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => $baseUrl.'/search?q={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ],
        [
            '@context' => 'https://schema.org',
            '@type' => 'SoftwareApplication',
            'name' => 'Untab',
            'applicationCategory' => 'BusinessApplication',
            'operatingSystem' => 'Web, iOS, Android',
            'url' => $baseUrl,
            'offers' => [
                '@type' => 'Offer',
                'price' => '0',
                'priceCurrency' => 'USD',
            ],
        ],
    ];
@endphp
{!! json_encode($baseSchemas, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>

@foreach($jsonLd as $schema)
<script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endforeach

@stack('seo')
