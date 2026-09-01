<?php

namespace App\Support;

/**
 * Static registry of the industry "how it helps" landing pages.
 *
 * Each industry is a self-contained marketing page targeting one local
 * business vertical. Content is original Untab copy (not taken from any
 * reference site) and is used to surface industry-specific benefits of the
 * Google Business Profile platform.
 */
class Industries
{
    /**
     * All industries, keyed by slug.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function all(): array
    {
        return [
            'dental-clinics' => static::dental(),
            'restaurants' => static::restaurants(),
            'real-estate' => static::realEstate(),
            'doctors-clinics' => static::doctors(),
            'salons-spas' => static::salons(),
            'legal-firms' => static::legal(),
            'coaching-institutes' => static::coaching(),
            'fitness-gyms' => static::fitness(),
            'auto-services' => static::auto(),
            'hotels-accommodation' => static::hotels(),
        ];
    }

    /**
     * Find one industry by slug, or null.
     */
    public static function find(string $slug): ?array
    {
        return self::all()[$slug] ?? null;
    }

    /**
     * Slugs for quick navigation.
     */
    public static function slugs(): array
    {
        return array_keys(self::all());
    }

    private static function dental(): array
    {
        return [
            'slug' => 'dental-clinics',
            'name' => 'Dental Clinics',
            'icon' => 'smile',
            'eyebrow' => 'For Dental Practices',
            'h1' => 'Manage every dental clinic location from one dashboard.',
            'intro' => 'Dental practices live and die by local visibility. Untab keeps every clinic\\'s Google Business Profile fresh — reviews answered, offers scheduled, and new patient flow tracked — without switching between profiles.',
            'heroFeatures' => [
                'Reply to every patient review with AI in seconds',
                'Schedule seasonal offers and treatment events across all branches',
                'Track calls, direction requests and bookings per clinic',
                'Give each dentist access to only their location',
            ],
            'metrics' => [
                ['value' => '42%', 'label' => 'more appointment calls'],
                ['value' => '2.1x', 'label' => 'faster review response'],
                ['value' => '5+', 'label' => 'locations per practice'],
            ],
            'painPoints' => [
                'Unclaimed or incomplete profiles that rank below competitors',
                'Reviews going unanswered because staff are busy with patients',
                'No central view of calls, directions or bookings across branches',
                'Offers and seasonal campaigns posted to each profile manually',
            ],
            'benefits' => [
                ['title' => 'AI review replies', 'desc' => 'Draft warm, on-brand replies to patient reviews — positive or negative — in your clinic\\'s voice, in seconds.'],
                ['title' => 'Freshness signals', 'desc' => 'Publish health tips, treatment events and seasonal offers across every branch so Google sees an active, trusted profile.'],
                ['title' => 'Branch benchmarking', 'desc' => 'Compare calls, directions and bookings side by side to spot your strongest and weakest locations.'],
                ['title' => 'Role-based access', 'desc' => 'Let each dentist or practice manager edit only their own location while the head office keeps a full view.'],
            ],
            'faqs' => [
                ['q' => 'How does Untab help a dental clinic get more patients?', 'a' => 'Untab makes sure your Google Business Profile is complete, responsive and active. Faster review replies and regular offers improve local rankings, which brings more calls and bookings.'],
                ['q' => 'Can I manage multiple clinic branches with Untab?', 'a' => 'Yes. Group all branches under one practice and filter the dashboard to a single location, a region, or the whole network.'],
                ['q' => 'Can the AI reply to patient reviews?', 'a' => 'Yes. The AI Review Reply Assistant drafts on-brand, empathetic responses to reviews, including concerns about wait times or treatment.'],
            ],
            'seoTitle' => 'Google Business Profile for Dental Clinics 2026 | Untab',
            'seoDesc' => 'How dental practices use Untab to manage every clinic branch, answer patient reviews with AI, and rank in Google Maps local search.',
            'keywords' => 'Google Business Profile dental clinics, dental local SEO, manage dental practice locations, dental reviews',
        ];
    }

    private static function restaurants(): array
    {
        return [
            'slug' => 'restaurants',
            'name' => 'Restaurants & Cafés',
            'icon' => 'utensils',
            'eyebrow' => 'For Restaurants & Cafés',
            'h1' => 'Get found by hungry local diners on Google Maps.',
            'intro' => 'The map pack decides which restaurant gets the table booking. Untab keeps every outlet\\'s profile current — photos, offers, menu posts and reviews — so you win the search a hungry customer makes at 7pm.',
            'heroFeatures' => [
                'post specials, offers and events across every outlet at once',
                'respond to every diner review with AI or one-click templates',
                'keep fresh photos and geotagged media on every profile',
                'track calls, directions and menu clicks per restaurant',
            ],
            'metrics' => [
                ['value' => '38%', 'label' => 'more profile clicks'],
                ['value' => '3x', 'label' => 'faster review replies'],
                ['value' => '10-100+', 'label' => 'outlets per chain'],
            ],
            'painPoints' => [
                'Outlets with inconsistent names, hours or menus across profiles',
                'No time to reply to hundreds of reviews across branches',
                'Special menus and festival offers posted outlet by outlet',
                'No idea which location drives the most calls and directions',
            ],
            'benefits' => [
                ['title' => 'Bulk Google Posts', 'desc' => 'Push a national special, menu update or festival offer to dozens of outlets in one click, with live Google preview.'],
                ['title' => 'Review consistency', 'desc' => 'Keep a consistent, professional brand voice across every outlet\\'s reviews — with AI drafting and one-click approval.'],
                ['title' => 'Photo & media library', 'desc' => 'Upload and geotag food, interior and team photos so each profile stays visually fresh.'],
                ['title' => 'Per-outlet insights', 'desc' => 'See calls, directions and clicks per location to reward top performers and fix laggards.'],
            ],
            'faqs' => [
                ['q' => 'How do restaurants win the Google map pack?', 'a' => 'A complete profile with regular Google Posts, fresh photos, and a fast response to reviews signals an active, trusted business — the signals Google rewards in local rankings.'],
                ['q' => 'Can Untab post to all my outlets at once?', 'a' => 'Yes. Create one Google Post and schedule it to any subset of outlets, from a single location to a whole franchise chain.'],
                ['q' => 'Does Untab help multi-outlet restaurant chains?', 'a' => 'Absolutely. Untab centralises review replies, posts and insights for restaurant groups and franchises so the head office keeps full control.'],
            ],
            'seoTitle' => 'Google Business Profile for Restaurants 2026 | Untab',
            'seoDesc' => 'How restaurants and cafés use Untab to post offers, answer reviews and rank higher on Google Maps to win more local diners.',
            'keywords' => 'Google Business Profile restaurants, restaurant local SEO, restaurant Google Posts, manage multiple restaurant locations',
        ];
    }

    private static function realEstate(): array
    {
        return [
            'slug' => 'real-estate',
            'name' => 'Real Estate & Property',
            'icon' => 'building-2',
            'eyebrow' => 'For Real Estate & Property',
            'h1' => 'Turn local property searches into site visits.',
            'intro' => 'Buyers and tenants search "apartments near me" on Google Maps before contacting an agent. Untab keeps every project, sale office and branch profile optimised and responsive.',
            'heroFeatures' => [
                'publish project updates and open-house events to every branch',
                'reply to client reviews and keep your reputation spotless',
                'manage a network of sale offices and site offices in one place',
                'track direction requests, calls and profile views per project',
            ],
            'metrics' => [
                ['value' => '31%', 'label' => 'more direction requests'],
                ['value' => '4x', 'label' => 'faster response rate'],
                ['value' => '20-500+', 'label' => 'properties per agency'],
            ],
            'painPoints' => [
                'Multiple sale offices with outdated or duplicate listings',
                'Client reviews spread across profiles and going unanswered',
                'Project launches and open houses posted manually to each office',
                'No clear view of which project drives the most enquiries',
            ],
            'benefits' => [
                ['title' => 'Project & event posts', 'desc' => 'Announce new launches, open houses and site-visit events across the whole network in one schedule.'],
                ['title' => 'Reputation management', 'desc' => 'Monitor and answer reviews for every office and project so prospects see a responsive, trustworthy brand.'],
                ['title' => 'Central command', 'desc' => 'Group branch and site offices under one agency profile with role-based access for each team.'],
                ['title' => 'Lead insights', 'desc' => 'See which projects drive calls and direction requests to focus your marketing budget.'],
            ],
            'faqs' => [
                ['q' => 'How does Untab help real estate agents get more local leads?', 'a' => 'Untab keeps every sale office and project profile complete and active, with fast review replies and regular posts — all signals that improve Google Maps rankings and bring more enquiries.'],
                ['q' => 'Can I manage a network of branch offices?', 'a' => 'Yes. Untab lets you manage many offices and projects under one agency, with the ability to filter to a region, office or single project.'],
                ['q' => 'Does Untab post project launches?', 'a' => 'Yes. You can create and schedule open-house and project-launch Google Posts across any subset of your offices.'],
            ],
            'seoTitle' => 'Google Business Profile for Real Estate 2026 | Untab',
            'seoDesc' => 'How real estate agencies use Untab to manage branch offices, project launches, reviews and Google Maps rankings in one dashboard.',
            'keywords' => 'Google Business Profile real estate, real estate local SEO, manage property branches, real estate reviews',
        ];
    }

    private static function doctors(): array
    {
        return [
            'slug' => 'doctors-clinics',
            'name' => 'Doctors & Medical Clinics',
            'icon' => 'stethoscope',
            'eyebrow' => 'For Doctors & Clinics',
            'h1' => 'Help patients find and book your clinic first.',
            'intro' => 'Patients choose a doctor by the profile they find on Google Maps. Untab helps clinics manage every location, answer patient reviews, and appear when someone searches for care near them.',
            'heroFeatures' => [
                'reply to patient reviews with an empathetic AI voice',
                'post health tips, care events and camp schedules per branch',
                'manage a multi-branch clinic or hospital network centrally',
                'track appointment calls and direction requests per location',
            ],
            'metrics' => [
                ['value' => '35%', 'label' => 'more appointment calls'],
                ['value' => '2.5x', 'label' => 'faster review response'],
                ['value' => '3-50+', 'label' => 'locations per group'],
            ],
            'painPoints' => [
                'Branches with incomplete profiles or wrong hours',
                'Patient reviews, concerns and complaints going unanswered',
                'Health camps and free-checkup events posted to each branch manually',
                'No central view of which services drive enquiries',
            ],
            'benefits' => [
                ['title' => 'Patient-focused AI replies', 'desc' => 'Draft warm, reassuring responses to patient reviews — perfect for healthcare, where trust matters most.'],
                ['title' => 'Services & specialities', 'desc' => 'List treatments, specialities and attributes so each branch matches what searching patients need.'],
                ['title' => 'Event & camp posts', 'desc' => 'Promote free health camps, vaccination drives and check-up events across all branches.'],
                ['title' => 'Multi-branch management', 'desc' => 'Give each doctor or clinic manager access to their own location while the group keeps a full view.'],
            ],
            'faqs' => [
                ['q' => 'How does Untab help clinics get more patients?', 'a' => 'A complete, responsive Google Business Profile with regular posts and quick review replies improves local rankings, helping your clinic appear first when patients search nearby.'],
                ['q' => 'Can Untab manage a hospital or multi-branch clinic?', 'a' => 'Yes. Group all branches under one network and filter the dashboard to any department, location or the whole group.'],
                ['q' => 'Is the AI appropriate for healthcare replies?', 'a' => 'Yes — the AI Review Reply Assistant uses a warm, empathetic tone you can customise, so patient replies feel human and reassuring.'],
            ],
            'seoTitle' => 'Google Business Profile for Doctors & Clinics 2026 | Untab',
            'seoDesc' => 'How doctors, clinics and hospital groups use Untab to manage every location, answer patient reviews, and rank on Google Maps.',
            'keywords' => 'Google Business Profile doctors, clinic local SEO, manage clinic locations, healthcare reviews',
        ];
    }

    private static function salons(): array
    {
        return [
            'slug' => 'salons-spas',
            'name' => 'Salons & Spas',
            'icon' => 'scissors',
            'eyebrow' => 'For Salons & Spas',
            'h1' => 'Fill more chairs with a Google profile that converts.',
            'intro' => 'Beauty is booked on impulse — often right after a Google Maps search. Untab keeps every salon and spa profile polished with fresh photos, offers and fast review replies.',
            'heroFeatures' => [
                'post seasonal offers and service highlights across every branch',
                'reply to every client review with a friendly AI voice',
                'keep fresh, geotagged photos on every profile',
                'track calls, directions and bookings per location',
            ],
            'metrics' => [
                ['value' => '29%', 'label' => 'more booking calls'],
                ['value' => '3x', 'label' => 'faster review replies'],
                ['value' => '2-100+', 'label' => 'branches per brand'],
            ],
            'painPoints' => [
                'Branch profiles with inconsistent offers and service lists',
                'Reviews that go unanswered when staff are with clients',
                'No time to update photos and posts for each outlet',
                'No view of which service or branch drives the most bookings',
            ],
            'benefits' => [
                ['title' => 'Offer & service posts', 'desc' => 'Promote seasonal packages, price lists and service highlights across all branches with a single schedule.'],
                ['title' => 'Consistent brand voice', 'desc' => 'Reply to client reviews with AI so every branch sounds on-brand and professional.'],
                ['title' => 'Visual freshness', 'desc' => 'Upload and geotag salon interiors, treatments and team photos to keep each profile inviting.'],
                ['title' => 'Branch performance', 'desc' => 'Compare calls and direction requests per location to see which branches convert best.'],
            ],
            'faqs' => [
                ['q' => 'How do salons get more bookings from Google?', 'a' => 'A complete profile with regular offers, fresh photos and prompt review replies raises your Google Maps ranking, bringing more booking calls and visits.'],
                ['q' => 'Can I manage multiple salon branches?', 'a' => 'Yes. Manage all branches under one brand, schedule posts to any subset, and let each branch manager access only their own profile.'],
                ['q' => 'Does Untab help with review generation?', 'a' => 'Yes — it provides direct review links and printable QR stands, plus AI replies, to turn happy clients into five-star reviews.'],
            ],
            'seoTitle' => 'Google Business Profile for Salons & Spas 2026 | Untab',
            'seoDesc' => 'How salons and spas use Untab to book more clients with offers, fresh photos and fast AI review replies on Google Maps.',
            'keywords' => 'Google Business Profile salons, salon local SEO, spa Google Posts, salon reviews',
        ];
    }

    private static function legal(): array
    {
        return [
            'slug' => 'legal-firms',
            'name' => 'Legal Firms & Lawyers',
            'icon' => 'scale',
            'eyebrow' => 'For Lawyers & Legal Firms',
            'h1' => 'Win the search when a client needs a lawyer today.',
            'intro' => 'Legal matters are urgent and local. Untab helps law firms manage every office and attorney profile, respond to client reviews, and appear when someone searches for legal help nearby.',
            'heroFeatures' => [
                'manage multi-office and multi-attorney profiles centrally',
                'reply to client reviews with a professional AI voice',
                'publish event, webinar and consultation posts',
                'track phone calls and direction requests per office',
            ],
            'metrics' => [
                ['value' => '27%', 'label' => 'more consultation calls'],
                ['value' => '2x', 'label' => 'faster response rate'],
                ['value' => '1-20+', 'label' => 'offices per firm'],
            ],
            'painPoints' => [
                'Multiple offices with separate, poorly maintained profiles',
                'Client reviews and testimonials going unanswered',
                'Webinars and consultation events posted to each office manually',
                'No view of which practice area or office drives enquiries',
            ],
            'benefits' => [
                ['title' => 'Practice-area clarity', 'desc' => 'List practice areas and services per office so your profile matches the specific legal search.'],
                ['title' => 'Professional AI replies', 'desc' => 'Respond to client reviews with a measured, trustworthy tone that reflects a legal practice.'],
                ['title' => 'Event & webinar posts', 'desc' => 'Promote consultations, webinars and community events across all offices.'],
                ['title' => 'Firm-level control', 'desc' => 'Manage every attorney and office under one firm profile with role-based access.'],
            ],
            'faqs' => [
                ['q' => 'How does Untab help law firms get more clients?', 'a' => 'Untab keeps each office profile complete and responsive, with fast review replies and regular posts that improve Google Maps rankings and bring more enquiries.'],
                ['q' => 'Can I manage multiple offices or attorneys?', 'a' => 'Yes. Manage multiple offices and attorneys under one firm, and filter by office, practice area or attorney.'],
                ['q' => 'Is the AI tone suitable for legal replies?', 'a' => 'Yes — you can set a professional, measured tone for attorney replies so client responses stay on-brand.'],
            ],
            'seoTitle' => 'Google Business Profile for Law Firms 2026 | Untab',
            'seoDesc' => 'How law firms use Untab to manage multi-office profiles, answer client reviews and rank on Google Maps for local legal searches.',
            'keywords' => 'Google Business Profile law firms, lawyer local SEO, manage law firm locations, legal reviews',
        ];
    }

    private static function coaching(): array
    {
        return [
            'slug' => 'coaching-institutes',
            'name' => 'Coaching Institutes & Education',
            'icon' => 'graduation-cap',
            'eyebrow' => 'For Coaching Institutes',
            'h1' => 'Be the institute students find first on Google Maps.',
            'intro' => 'Parents and students search "best coaching near me" on Google Maps. Untab helps institutes manage every branch and centre, respond to reviews, and rank when it matters.',
            'heroFeatures' => [
                'manage multiple branches, centres and batches centrally',
                'reply to parent and student reviews with AI',
                'publish course, batch and admission-fee posts',
                'track calls and direction requests per centre',
            ],
            'metrics' => [
                ['value' => '40%', 'label' => 'more admission enquiries'],
                ['value' => '2.5x', 'label' => 'faster review response'],
                ['value' => '5-100+', 'label' => 'branches per institute'],
            ],
            'painPoints' => [
                'Branch centres with inconsistent contact info and reviews',
                'Admission announcements posted to each centre manually',
                'Parent reviews and feedback going unanswered',
                'No central view of which branch is most popular',
            ],
            'benefits' => [
                ['title' => 'Admission & batch posts', 'desc' => 'Promote new batches, admission openings and fee details across all centres in one schedule.'],
                ['title' => 'Trust & reviews', 'desc' => 'Answer parent and student reviews promptly to build the trust that drives admissions.'],
                ['title' => 'Multi-centre command', 'desc' => 'Group branches and centres under one institute with role-based manager access.'],
                ['title' => 'Enquiry tracking', 'desc' => 'See calls and direction requests per centre to know which branch is winning.'],
            ],
            'faqs' => [
                ['q' => 'How does Untab help coaching institutes get more admissions?', 'a' => 'Untab keeps every centre profile complete and active with regular admission posts and fast review replies — signals that improve your Google Maps ranking and bring more enquiries.'],
                ['q' => 'Can I manage multiple coaching centres?', 'a' => 'Yes. Manage all branches and centres under one institute, and post admission updates to any subset of them.'],
                ['q' => 'Does Untab help with parent reviews?', 'a' => 'Yes — the AI Review Reply Assistant drafts friendly, informative replies to parent and student reviews in seconds.'],
            ],
            'seoTitle' => 'Google Business Profile for Coaching Institutes 2026 | Untab',
            'seoDesc' => 'How coaching institutes and educational centres use Untab to manage branches, admission posts, reviews and Google Maps rankings.',
            'keywords' => 'Google Business Profile coaching institutes, education local SEO, manage tuition centres, institute reviews',
        ];
    }

    private static function fitness(): array
    {
        return [
            'slug' => 'fitness-gyms',
            'name' => 'Fitness & Gyms',
            'icon' => 'dumbbell',
            'eyebrow' => 'For Gyms & Fitness Studios',
            'h1' => 'Turn "gym near me" searches into memberships.',
            'intro' => 'Gym sign-ups are local and competitive. Untab keeps every fitness studio profile active with offers, class schedules and fast review replies that pull in new members.',
            'heroFeatures' => [
                'post membership offers and class schedules across branches',
                'reply to member reviews with a motivating AI voice',
                'manage multiple studios and franchises centrally',
                'track calls and direction requests per location',
            ],
            'metrics' => [
                ['value' => '33%', 'label' => 'more membership calls'],
                ['value' => '3x', 'label' => 'faster review replies'],
                ['value' => '1-50+', 'label' => 'locations per brand'],
            ],
            'painPoints' => [
                'Studio profiles with outdated offers and schedules',
                'Member reviews and class feedback going unanswered',
                'Franchise locations with inconsistent branding',
                'No view of which studio converts best',
            ],
            'benefits' => [
                ['title' => 'Offer & schedule posts', 'desc' => 'Promote memberships, trial classes and seasonal offers across every studio in one schedule.'],
                ['title' => 'Member engagement', 'desc' => 'Reply quickly to member reviews to keep motivation and your 5-star reputation strong.'],
                ['title' => 'Franchise management', 'desc' => 'Keep every franchise studio on-brand and consistent with centralised controls.'],
                ['title' => 'Location insights', 'desc' => 'Compare calls and direction requests per studio to reward top performers.'],
            ],
            'faqs' => [
                ['q' => 'How do gyms get more memberships from Google?', 'a' => 'A complete profile with regular offers, class posts and prompt review replies improves your Google Maps ranking, bringing more calls and memberships.'],
                ['q' => 'Can Untab manage a gym franchise?', 'a' => 'Yes. Manage multiple studios and franchises under one brand with centralised posting, reviews and insights.'],
                ['q' => 'Does Untab schedule class and offer posts?', 'a' => 'Yes — the Google Posts scheduler lets you schedule membership offers and class updates across any subset of studios.'],
            ],
            'seoTitle' => 'Google Business Profile for Gyms & Fitness 2026 | Untab',
            'seoDesc' => 'How gyms and fitness studios use Untab to post offers, answer member reviews and rank on Google Maps for local memberships.',
            'keywords' => 'Google Business Profile gyms, fitness local SEO, gym offers Google Posts, franchise fitness management',
        ];
    }

    private static function auto(): array
    {
        return [
            'slug' => 'auto-services',
            'name' => 'Auto Services & Dealerships',
            'icon' => 'car',
            'eyebrow' => 'For Auto Services & Dealerships',
            'h1' => 'Win the search when a car needs a service today.',
            'intro' => 'Breakdowns and maintenance are urgent local searches. Untab helps auto workshops, garages and dealerships manage every location, respond to reviews, and rank on Google Maps.',
            'heroFeatures' => [
                'manage service centres and showrooms centrally',
                'reply to customer reviews with AI in seconds',
                'post service offers and seasonal maintenance drives',
                'track calls and direction requests per centre',
            ],
            'metrics' => [
                ['value' => '32%', 'label' => 'more service bookings'],
                ['value' => '2.5x', 'label' => 'faster review response'],
                ['value' => '1-30+', 'label' => 'centres per dealer'],
            ],
            'painPoints' => [
                'Workshops with outdated hours and service lists',
                'Customer reviews and complaints going unanswered',
                'Service offers posted to each branch manually',
                'No view of which centre drives the most work',
            ],
            'benefits' => [
                ['title' => 'Service & offer posts', 'desc' => 'Promote seasonal service drives, discounts and maintenance offers across all centres.'],
                ['title' => 'Reputation & trust', 'desc' => 'Answer customer reviews to build trust for a business where reliability matters most.'],
                ['title' => 'Network management', 'desc' => 'Manage workshops, showrooms and service centres under one dealer network.'],
                ['title' => 'Booking insights', 'desc' => 'Track calls and direction requests per centre to focus your service marketing.'],
            ],
            'faqs' => [
                ['q' => 'How does Untab help auto workshops get more bookings?', 'a' => 'Untab keeps every service centre profile complete and active with regular offers and fast review replies — signals that boost Google Maps ranking and bring more bookings.'],
                ['q' => 'Can I manage dealerships and service centres?', 'a' => 'Yes. Manage showrooms, workshops and service centres under one dealer network with role-based access.'],
                ['q' => 'Does Untab post service offers?', 'a' => 'Yes — the Google Posts scheduler lets you publish service offers and seasonal maintenance drives across any subset of centres.'],
            ],
            'seoTitle' => 'Google Business Profile for Auto Services 2026 | Untab',
            'seoDesc' => 'How auto workshops, garages and dealerships use Untab to manage centres, answer reviews and rank on Google Maps.',
            'keywords' => 'Google Business Profile auto services, car workshop local SEO, dealership Google Posts, auto reviews',
        ];
    }

    private static function hotels(): array
    {
        return [
            'slug' => 'hotels-accommodation',
            'name' => 'Hotels & Accommodation',
            'icon' => 'bed-double',
            'eyebrow' => 'For Hotels & Accommodation',
            'h1' => 'Be the stay travellers book from Google Maps.',
            'intro' => 'Travellers search "hotel near me" on Google Maps when they arrive. Untab keeps every property profile fresh with photos, offers and fast review replies that drive direct bookings.',
            'heroFeatures' => [
                'manage multiple properties and rooms centrally',
                'reply to guest reviews with a warm AI voice',
                'post seasonal offers and stay packages',
                'track calls, directions and booking clicks per property',
            ],
            'metrics' => [
                ['value' => '25%', 'label' => 'more direct bookings'],
                ['value' => '3x', 'label' => 'faster review response'],
                ['value' => '1-20+', 'label' => 'properties per group'],
            ],
            'painPoints' => [
                'Property profiles with outdated photos and amenities',
                'Guest reviews going unanswered, hurting rankings',
                'Seasonal packages posted to each property manually',
                'No view of which property drives the most enquiries',
            ],
            'benefits' => [
                ['title' => 'Offer & stay posts', 'desc' => 'Promote seasonal packages, rooms and amenities across every property in one schedule.'],
                ['title' => 'Guest satisfaction', 'desc' => 'Reply to guest reviews promptly to build trust and lift your rating.'],
                ['title' => 'Property portfolio', 'desc' => 'Manage multiple hotels and properties under one group with centralised control.'],
                ['title' => 'Direct booking insights', 'desc' => 'Track calls and booking clicks per property to optimise your portfolio.'],
            ],
            'faqs' => [
                ['q' => 'How does Untab help hotels get more direct bookings?', 'a' => 'A complete, fresh profile with regular offers and fast review replies improves your Google Maps ranking and brings more direct booking calls and clicks.'],
                ['q' => 'Can I manage multiple properties?', 'a' => 'Yes. Manage multiple properties and rooms under one hotel group with role-based access.'],
                ['q' => 'Does Untab post stay packages?', 'a' => 'Yes — you can schedule seasonal offers and stay packages across any subset of properties.'],
            ],
            'seoTitle' => 'Google Business Profile for Hotels 2026 | Untab',
            'seoDesc' => 'How hotels and accommodation groups use Untab to manage properties, guest reviews, offers and Google Maps rankings.',
            'keywords' => 'Google Business Profile hotels, hotel local SEO, manage hotel properties, hotel guest reviews',
        ];
    }
}
