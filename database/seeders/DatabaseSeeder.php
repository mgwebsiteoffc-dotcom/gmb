<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Location;
use App\Models\Review;
use App\Models\Post;
use App\Models\MediaItem;
use App\Models\SearchQuery;
use App\Models\SearchPage;
use App\Models\TeamMember;
use App\Models\AgencySetting;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Clients
        $c1 = Client::create([
            'name' => 'Apex Dental Care',
            'category' => 'Dental Clinic Chain',
            'logo' => '🦷',
            'color' => '#2563eb',
            'account_manager' => 'Sarah Jenkins',
            'monthly_retainer' => '$1,800/mo',
            'active_since' => 'Jan 2024'
        ]);

        $c2 = Client::create([
            'name' => 'Urban Crust Pizza Co.',
            'category' => 'Restaurant & Franchise',
            'logo' => '🍕',
            'color' => '#ea580c',
            'account_manager' => 'Marcus Vance',
            'monthly_retainer' => '$2,400/mo',
            'active_since' => 'Nov 2023'
        ]);

        $c3 = Client::create([
            'name' => 'Horizon Law Group',
            'category' => 'Legal & Attorney Practice',
            'logo' => '⚖️',
            'color' => '#4f46e5',
            'account_manager' => 'Elena Rostova',
            'monthly_retainer' => '$1,950/mo',
            'active_since' => 'Mar 2024'
        ]);

        $c4 = Client::create([
            'name' => 'Elevate Wellness & Spa',
            'category' => 'Health & Beauty Franchise',
            'logo' => '🌿',
            'color' => '#059669',
            'account_manager' => 'Sarah Jenkins',
            'monthly_retainer' => '$2,200/mo',
            'active_since' => 'Feb 2024'
        ]);

        // 2. Locations
        $l1 = Location::create([
            'client_id' => $c1->id,
            'name' => 'Apex Dental Care - Downtown Austin',
            'address' => '401 Congress Ave, Suite 120, Austin, TX 78701',
            'phone' => '(512) 555-0192',
            'category' => 'Dentist',
            'verified' => true,
            'rating' => 4.9,
            'review_count' => 342,
            'unanswered_reviews' => 2,
            'health_score' => 98,
            'monthly_views' => 24500,
            'monthly_calls' => 312,
            'monthly_directions' => 480,
            'monthly_website_clicks' => 890,
            'sync_status' => 'synced',
            'place_id' => 'ChIJN1t_tDeuEmsRUsoyG83frY4',
            'cover_image' => 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=600&q=80',
            'primary_manager' => 'Dr. James Wilson'
        ]);

        $l2 = Location::create([
            'client_id' => $c1->id,
            'name' => 'Apex Dental Care - Domain Northside',
            'address' => '11800 Domain Dr #150, Austin, TX 78758',
            'phone' => '(512) 555-0144',
            'category' => 'Dentist',
            'verified' => true,
            'rating' => 4.8,
            'review_count' => 218,
            'unanswered_reviews' => 0,
            'health_score' => 95,
            'monthly_views' => 18900,
            'monthly_calls' => 240,
            'monthly_directions' => 395,
            'monthly_website_clicks' => 710,
            'sync_status' => 'synced',
            'place_id' => 'ChIJ42c4c-y1RIYR5x9lq2vE3G0',
            'cover_image' => 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&w=600&q=80',
            'primary_manager' => 'Dr. Alicia Keyser'
        ]);

        $l3 = Location::create([
            'client_id' => $c1->id,
            'name' => 'Apex Dental Care - South Lamar',
            'address' => '2200 S Lamar Blvd, Austin, TX 78704',
            'phone' => '(512) 555-0188',
            'category' => 'Cosmetic Dentist',
            'verified' => true,
            'rating' => 4.7,
            'review_count' => 165,
            'unanswered_reviews' => 1,
            'health_score' => 92,
            'monthly_views' => 14200,
            'monthly_calls' => 185,
            'monthly_directions' => 310,
            'monthly_website_clicks' => 520,
            'sync_status' => 'synced',
            'place_id' => 'ChIJL6bXwZSwRIYR7oFzT0W5m9E',
            'cover_image' => 'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?auto=format&fit=crop&w=600&q=80',
            'primary_manager' => 'Dr. Kevin Patel'
        ]);

        $l4 = Location::create([
            'client_id' => $c1->id,
            'name' => 'Apex Dental Care - Round Rock Metro',
            'address' => '2000 N Mays St, Round Rock, TX 78664',
            'phone' => '(512) 555-0177',
            'category' => 'Pediatric Dentist',
            'verified' => true,
            'rating' => 4.9,
            'review_count' => 289,
            'unanswered_reviews' => 0,
            'health_score' => 96,
            'monthly_views' => 19800,
            'monthly_calls' => 275,
            'monthly_directions' => 410,
            'monthly_website_clicks' => 780,
            'sync_status' => 'synced',
            'place_id' => 'ChIJX9W-y7mvRIYRFZpqE1tU2P8',
            'cover_image' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=600&q=80',
            'primary_manager' => 'Dr. Rachel Vance'
        ]);

        $l5 = Location::create([
            'client_id' => $c2->id,
            'name' => 'Urban Crust Pizza Co. - Downtown Austin',
            'address' => '608 E 6th St, Austin, TX 78701',
            'phone' => '(512) 555-8833',
            'category' => 'Pizza Restaurant',
            'verified' => true,
            'rating' => 4.7,
            'review_count' => 840,
            'unanswered_reviews' => 3,
            'health_score' => 94,
            'monthly_views' => 42000,
            'monthly_calls' => 890,
            'monthly_directions' => 1420,
            'monthly_website_clicks' => 2150,
            'sync_status' => 'synced',
            'place_id' => 'ChIJV4Y4G4uvRIYRA4xP3B8e0gM',
            'cover_image' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?auto=format&fit=crop&w=600&q=80',
            'primary_manager' => 'Chef Marco Rossi'
        ]);

        $l6 = Location::create([
            'client_id' => $c2->id,
            'name' => 'Urban Crust Pizza Co. - South Congress',
            'address' => '1603 S Congress Ave, Austin, TX 78704',
            'phone' => '(512) 555-8844',
            'category' => 'Pizza Restaurant',
            'verified' => true,
            'rating' => 4.8,
            'review_count' => 620,
            'unanswered_reviews' => 1,
            'health_score' => 97,
            'monthly_views' => 36500,
            'monthly_calls' => 720,
            'monthly_directions' => 1180,
            'monthly_website_clicks' => 1840,
            'sync_status' => 'synced',
            'place_id' => 'ChIJy9t_qSuwRIYRE4w2Z4a6c8A',
            'cover_image' => 'https://images.unsplash.com/photo-1590947132387-155cc02f3212?auto=format&fit=crop&w=600&q=80',
            'primary_manager' => 'Leo Bennett'
        ]);

        $l7 = Location::create([
            'client_id' => $c3->id,
            'name' => 'Horizon Law Group - Chicago Loop HQ',
            'address' => '200 S Michigan Ave, Chicago, IL 60604',
            'phone' => '(312) 555-4400',
            'category' => 'Personal Injury Attorney',
            'verified' => true,
            'rating' => 4.9,
            'review_count' => 178,
            'unanswered_reviews' => 0,
            'health_score' => 99,
            'monthly_views' => 16500,
            'monthly_calls' => 142,
            'monthly_directions' => 98,
            'monthly_website_clicks' => 640,
            'sync_status' => 'synced',
            'place_id' => 'ChIJ7-1hZgDQDogRE7t4L5n1W2A',
            'cover_image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=600&q=80',
            'primary_manager' => 'Robert Vance, Esq.'
        ]);

        $l8 = Location::create([
            'client_id' => $c4->id,
            'name' => 'Elevate Wellness - Miami Brickell',
            'address' => '1100 Brickell Bay Dr, Miami, FL 33131',
            'phone' => '(305) 555-7722',
            'category' => 'Day Spa',
            'verified' => true,
            'rating' => 4.9,
            'review_count' => 420,
            'unanswered_reviews' => 1,
            'health_score' => 98,
            'monthly_views' => 31000,
            'monthly_calls' => 480,
            'monthly_directions' => 850,
            'monthly_website_clicks' => 1620,
            'sync_status' => 'synced',
            'place_id' => 'ChIJ09B5m6m22YgRJ8yP2A5k1qE',
            'cover_image' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=600&q=80',
            'primary_manager' => 'Sophia Martinez'
        ]);

        // 3. Reviews
        Review::create([
            'location_id' => $l1->id,
            'author_name' => 'David K. Miller',
            'author_photo' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=120&q=80',
            'rating' => 5,
            'date_text' => '2 hours ago',
            'snippet' => 'Dr. James and his entire dental team are outstanding! Got an emergency crown done without any pain. Best dental clinic in downtown Austin.',
            'sentiment' => 'positive',
            'status' => 'unanswered',
            'keywords' => ['emergency crown', 'downtown Austin', 'no pain', 'dental clinic']
        ]);

        Review::create([
            'location_id' => $l5->id,
            'author_name' => 'Samantha Lee',
            'author_photo' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=120&q=80',
            'rating' => 5,
            'date_text' => '5 hours ago',
            'snippet' => 'The wood-fired truffle pizza is insane! Fast service even on a bustling Friday night. Definitely coming back with friends.',
            'sentiment' => 'positive',
            'status' => 'unanswered',
            'keywords' => ['truffle pizza', 'wood-fired', 'fast service']
        ]);

        Review::create([
            'location_id' => $l5->id,
            'author_name' => 'Brad Thompson',
            'author_photo' => 'https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?auto=format&fit=crop&w=120&q=80',
            'rating' => 3,
            'date_text' => '1 day ago',
            'snippet' => 'Pizza taste was delicious as always, but our pickup order took 25 minutes longer than promised in the app. Staff was apologetic though.',
            'sentiment' => 'neutral',
            'status' => 'unanswered',
            'keywords' => ['pickup order', 'wait time', 'delicious pizza']
        ]);

        Review::create([
            'location_id' => $l3->id,
            'author_name' => 'Jessica Martinez',
            'author_photo' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=120&q=80',
            'rating' => 5,
            'date_text' => '1 day ago',
            'snippet' => 'Teeth whitening results exceeded my expectations. Dr. Kevin explained everything so thoroughly and transparently with no hidden fees.',
            'sentiment' => 'positive',
            'status' => 'replied',
            'reply' => 'Thank you so much Jessica! We are thrilled to hear you love your brighter smile. Dr. Kevin and the South Lamar team appreciate your kind recommendation!',
            'replied_at' => now()->subDay(),
            'keywords' => ['teeth whitening', 'transparent pricing', 'Dr. Kevin']
        ]);

        Review::create([
            'location_id' => $l8->id,
            'author_name' => 'Alexandre Dubois',
            'author_photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=120&q=80',
            'rating' => 2,
            'date_text' => '2 days ago',
            'snippet' => 'The deep tissue massage was okay, but the reception area was noisy and my appointment started 15 minutes late due to room turnaround.',
            'sentiment' => 'negative',
            'status' => 'unanswered',
            'keywords' => ['deep tissue massage', 'late appointment', 'reception noise']
        ]);

        Review::create([
            'location_id' => $l7->id,
            'author_name' => 'Michael Chang',
            'author_photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=120&q=80',
            'rating' => 5,
            'date_text' => '3 days ago',
            'snippet' => 'Attorney Robert Vance helped me navigate my commercial dispute smoothly. Clear communication and relentless dedication to winning our case.',
            'sentiment' => 'positive',
            'status' => 'replied',
            'reply' => 'Thank you Michael. It was a privilege representing your business in Chicago. We are proud of the outcome and wish you continued commercial success.',
            'replied_at' => now()->subDays(3),
            'keywords' => ['commercial dispute', 'Robert Vance', 'Chicago attorney']
        ]);

        // 4. Posts
        Post::create([
            'title' => 'Labor Day Weekend Special: Free Whitening Consultation',
            'type' => 'OFFER',
            'target_locations' => [$l1->id, $l2->id, $l3->id, $l4->id],
            'target_location_names' => 'All Apex Dental Locations (4)',
            'content' => '✨ Get your brightest smile for fall! Book any comprehensive dental exam this week and receive a complimentary professional whitening evaluation. Limited appointments available.',
            'coupon_code' => 'FALLSMILE26',
            'terms' => 'Valid for new and returning patients. Ends Sept 10.',
            'cta_type' => 'BOOK',
            'cta_url' => 'https://apexdentalcare.com/book-appointment',
            'media_url' => 'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?auto=format&fit=crop&w=800&q=80',
            'status' => 'PUBLISHED',
            'publish_date' => '2026-08-28 09:00',
            'views' => 3420,
            'clicks' => 184
        ]);

        Post::create([
            'title' => 'New Artisan Burrata & Fig Pizza on the Menu',
            'type' => 'WHATS_NEW',
            'target_locations' => [$l5->id, $l6->id],
            'target_location_names' => 'All Urban Crust Locations (2)',
            'content' => '🔥 Crafted with fresh Italian burrata, mission figs, prosciutto di Parma, and hot honey drizzle. Available exclusively this month at all Urban Crust locations!',
            'cta_type' => 'ORDER',
            'cta_url' => 'https://urbancrustpizza.com/order-online',
            'media_url' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?auto=format&fit=crop&w=800&q=80',
            'status' => 'PUBLISHED',
            'publish_date' => '2026-08-29 11:30',
            'views' => 4890,
            'clicks' => 312
        ]);

        Post::create([
            'title' => 'Live Q&A: Commercial Real Estate Lease Pitfalls to Avoid in 2026',
            'type' => 'EVENT',
            'target_locations' => [$l7->id],
            'target_location_names' => 'Horizon Law Group - Chicago HQ',
            'content' => 'Join Senior Partner Robert Vance for a complimentary webinar on navigating changing commercial real estate lease agreements in Illinois.',
            'event_start' => '2026-09-08 14:00',
            'event_end' => '2026-09-08 15:30',
            'cta_type' => 'SIGN_UP',
            'cta_url' => 'https://horizonlawchicago.com/events/lease-pitfalls',
            'media_url' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80',
            'status' => 'SCHEDULED',
            'publish_date' => '2026-09-04 10:00',
            'views' => 0,
            'clicks' => 0
        ]);

        // 5. Media Items
        MediaItem::create([
            'location_id' => $l1->id,
            'title' => 'Modern Clinic Operatory - Treatment Suite 1',
            'category' => 'Interior',
            'url' => 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=800&q=80',
            'geotag' => '30.2672° N, 97.7431° W (Austin, TX)',
            'alt_text' => 'State of the art dental operatory with ergonomic patient chair in downtown Austin',
            'views' => 6420
        ]);

        MediaItem::create([
            'location_id' => $l5->id,
            'title' => 'Fresh Wood Fired Margherita Pizza Out of Oven',
            'category' => 'Food / Product',
            'url' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?auto=format&fit=crop&w=800&q=80',
            'geotag' => '30.2669° N, 97.7370° W (Austin 6th St)',
            'alt_text' => 'Fresh wood fired margherita pizza with basil and mozzarella at Urban Crust 6th St',
            'views' => 11200
        ]);

        MediaItem::create([
            'location_id' => $l8->id,
            'title' => 'Relaxing Spa Treatment Room & Hydrotherapy',
            'category' => 'Interior',
            'url' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=800&q=80',
            'geotag' => '25.7617° N, 80.1918° W (Miami Brickell)',
            'alt_text' => 'Tranquil private massage and relaxation room with bamboo accents in Brickell Miami',
            'views' => 4890
        ]);

        MediaItem::create([
            'location_id' => $l7->id,
            'title' => 'Downtown Law Firm Executive Boardroom',
            'category' => 'Interior',
            'url' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80',
            'geotag' => '41.8818° N, 87.6231° W (Chicago Loop)',
            'alt_text' => 'Modern corporate legal consultation boardroom overlooking Chicago skyline',
            'views' => 3150
        ]);

        // 6. Search Console Queries & Pages
        SearchQuery::create(['query' => 'emergency dentist downtown austin', 'clicks' => 1840, 'impressions' => 14200, 'ctr' => '12.96%', 'position' => 1.4]);
        SearchQuery::create(['query' => 'best wood fired pizza south congress', 'clicks' => 1520, 'impressions' => 18900, 'ctr' => '8.04%', 'position' => 2.1]);
        SearchQuery::create(['query' => 'teeth whitening near domain austin', 'clicks' => 1140, 'impressions' => 12400, 'ctr' => '9.19%', 'position' => 1.8]);
        SearchQuery::create(['query' => 'chicago commercial lease attorney', 'clicks' => 980, 'impressions' => 8400, 'ctr' => '11.67%', 'position' => 2.4]);
        SearchQuery::create(['query' => 'brickell day spa massage deals', 'clicks' => 840, 'impressions' => 9600, 'ctr' => '8.75%', 'position' => 2.7]);
        SearchQuery::create(['query' => 'pediatric dentist round rock tx', 'clicks' => 760, 'impressions' => 6800, 'ctr' => '11.18%', 'position' => 1.9]);

        SearchPage::create(['url' => '/locations/downtown-austin-dentist', 'clicks' => 4200, 'impressions' => 48000, 'ctr' => '8.75%', 'position' => 1.9]);
        SearchPage::create(['url' => '/menu/wood-fired-specialties', 'clicks' => 3800, 'impressions' => 52000, 'ctr' => '7.31%', 'position' => 2.3]);
        SearchPage::create(['url' => '/services/emergency-dental-care', 'clicks' => 2900, 'impressions' => 31000, 'ctr' => '9.35%', 'position' => 1.6]);
        SearchPage::create(['url' => '/spa-packages/brickell-retreat', 'clicks' => 2100, 'impressions' => 26000, 'ctr' => '8.08%', 'position' => 2.4]);

        // 7. Team
        TeamMember::create([
            'name' => 'Sarah Jenkins',
            'email' => 'sarah@ampli5agency.com',
            'role' => 'Account Director',
            'assigned_clients' => [$c1->id, $c4->id],
            'permissions' => ['posts' => true, 'reviews' => true, 'media' => true, 'reports' => true, 'settings' => true],
            'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&q=80',
            'status' => 'Active'
        ]);

        TeamMember::create([
            'name' => 'Marcus Vance',
            'email' => 'marcus@ampli5agency.com',
            'role' => 'Local SEO Specialist',
            'assigned_clients' => [$c2->id],
            'permissions' => ['posts' => true, 'reviews' => true, 'media' => true, 'reports' => true, 'settings' => false],
            'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=120&q=80',
            'status' => 'Active'
        ]);

        TeamMember::create([
            'name' => 'Elena Rostova',
            'email' => 'elena@ampli5agency.com',
            'role' => 'Content & Review Manager',
            'assigned_clients' => [$c3->id],
            'permissions' => ['posts' => true, 'reviews' => true, 'media' => true, 'reports' => false, 'settings' => false],
            'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=120&q=80',
            'status' => 'Active'
        ]);

        // 8. Settings
        AgencySetting::create([
            'agency_name' => 'Apex Local Growth Agency',
            'custom_domain' => 'clients.apexlocalseo.com',
            'brand_color' => '#1a35c8',
            'support_email' => 'support@apexlocalseo.com',
            'ai_model' => 'gpt-4o-mini',
            'email_alerts' => true,
            'sms_alerts' => false
        ]);
    }
}
