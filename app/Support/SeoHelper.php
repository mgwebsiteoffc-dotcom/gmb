<?php

namespace App\Support;

class SeoHelper
{
    /**
     * Build a FAQPage structured-data array.
     */
    public static function faqSchema(array $faqs): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => collect($faqs)->map(fn ($faq) => [
                '@type' => 'Question',
                'name' => $faq['q'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['a'],
                ],
            ])->all(),
        ];
    }

    /**
     * Build a BreadcrumbList structured-data array.
     */
    public static function breadcrumbSchema(array $crumbs): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($crumbs)->map(fn ($crumb, $i) => [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => $crumb['name'],
                'item' => $crumb['url'],
            ])->values()->all(),
        ];
    }

    /**
     * Build a SoftwareApplication structured-data array.
     */
    public static function softwareApplicationSchema(array $attrs = []): array
    {
        return array_merge([
            '@context' => 'https://schema.org',
            '@type' => 'SoftwareApplication',
            'name' => $attrs['name'] ?? 'Untab',
            'applicationCategory' => $attrs['category'] ?? 'BusinessApplication',
            'operatingSystem' => $attrs['os'] ?? 'Web, iOS, Android',
            'url' => $attrs['url'] ?? url('/'),
            'description' => $attrs['description'] ?? 'Google Business Profile management platform for agencies and multi-location brands.',
            'offers' => [
                '@type' => 'Offer',
                'price' => $attrs['price'] ?? '0',
                'priceCurrency' => 'USD',
            ],
        ], $attrs['extra'] ?? []);
    }
}
