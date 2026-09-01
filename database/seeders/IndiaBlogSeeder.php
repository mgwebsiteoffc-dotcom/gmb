<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;

/**
 * India-market blog content.
 *
 * Uses updateOrCreate (keyed on slug) so it is safe to re-run without
 * creating duplicate posts, and it merges cleanly with the base BlogSeeder.
 */
class IndiaBlogSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Google Business Profile for Indian Small Businesses: The Complete 2026 Guide',
                'slug' => 'google-business-profile-india-small-business-2026-guide',
                'excerpt' => 'Why a Google Business Profile now matters more than JustDial or IndiaMART for kirana stores, clinics, salons and restaurants in India — and the exact setup steps to get found on Google Maps.',
                'category' => 'India',
                'author' => 'Untab Team',
                'featured' => true,
                'status' => 'published',
                'tags' => ['india', 'google-business-profile', 'gbp-india', 'local-seo-india'],
                'keywords' => 'Google Business Profile India, GBP setup India, Google Maps ranking India, local SEO India, JustDial alternative',
                'meta_title' => 'Google Business Profile for Indian Small Businesses (2026 Guide) | Untab',
                'meta_description' => 'How Indian small businesses (kirana, clinics, salons, restaurants) can set up a Google Business Profile and rank on Google Maps in 2026 — beyond JustDial and IndiaMART.',
                'cover_image' => 'https://images.unsplash.com/photo-1524492412937-b28074a5d7da?auto=format&fit=crop&w=1200&q=80',
                'content' => '<p>From a <strong>kirana store in Jaipur</strong> to a <strong>dental clinic in Pune</strong>, the single highest-ROI local marketing move in India in 2026 is a properly claimed Google Business Profile (GBP).</p><h2>Why GBP beats directories in India</h2><p>JustDial and IndiaMART still send leads, but they charge for visibility and rarely rank your <em>physical</em> location. A Google Business Profile puts your shop directly on the Google Maps local pack — the first thing an Indian customer sees when they search <em>dentist near me</em>, <em>ac repair in my area</em>, or <em>best biryani ner me</em>.</p><blockquote>Over 80% of Indian consumers who search locally on their phone visit or call a business within 24 hours. Your GBP is that storefront.</blockquote><h2>Mobile-first, vernacular search</h2><p>India searches on mobile first, and in Hindi, Hinglish, and regional languages. Add your local-language <strong>short name</strong>, write your description in the language your customers actually speak, and list service keywords in Hindi (e.g. <strong>दांत का डॉक्टर</strong>) alongside English. Google parses both.</p><h2>Step-by-step setup</h2><ol><li>Create or claim your profile at business.google.com</li><li>Choose the exact primary category (it matters more than you think)</li><li>Enter a consistent business name, address and phone — identical everywhere on the web</li><li>Add your service area (PMR / pin-code level) for home-serve businesses</li><li>Upload real, geotagged photos of your shop, menu, team and interior</li><li>Verify by phone, email, video, or postcard</li></ol><h2>Freshness is the real edge</h2><p>The competitive edge in India comes from freshness. Profiles that publish offers, answer every review, and update photos win. A single owner can now manage a clinic or a salon chain like a franchise brand.</p><h2>How Untab helps Indian businesses</h2><p>Untab centralises review replies, Google Posts, and local insights for one or many Indian locations. The AI Review Reply Assistant drafts replies in Hindi and English, and the Google Posts scheduler pins Diwali and festival offers across all your branches in one click.</p>',
            ],
            [
                'title' => 'How to Get More Google Reviews From Indian Customers (Hindi & Vernacular)',
                'slug' => 'get-more-google-reviews-india-hindi-vernacular',
                'excerpt' => 'The compliant way to earn reviews from Indian customers: WhatsApp share links, QR codes at the counter, and replies in Hindi, Hinglish, and regional languages — without falling foul of Google policy.',
                'category' => 'India',
                'author' => 'Untab Team',
                'featured' => true,
                'status' => 'published',
                'tags' => ['india', 'google-reviews', 'review-generation', 'whatsapp'],
                'keywords' => 'get Google reviews India, WhatsApp review link, Hindi review reply, review generation India, fake review penalty',
                'meta_title' => 'How to Get More Google Reviews From Indian Customers | Untab',
                'meta_description' => 'Earn more Google reviews from Indian customers using WhatsApp share links, counter QR codes, and Hindi/Hinglish replies — the compliant, policy-safe way.',
                'cover_image' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=1200&q=80',
                'content' => '<p>Reviews are the currency of local trust in India. A customer deciding between two clinics on Google Maps reads the stars and the number of reviews — often before ever opening your website.</p><h2>Ask at the right moment</h2><p>The best time to ask for a review is <strong>immediately after</strong> a successful interaction — a good meal, a clean darshan, a finished job. Send the Google review link to the customer\'s WhatsApp within minutes of their visit.</p><blockquote>A review request sent within 30 minutes of a positive experience converts 4x better than one sent a week later.</blockquote><h2>Use a QR code at the counter</h2><p>Print a review QR code and place it at the billing counter, on the checkout, or on the table. Customers scan, and the pre-filled Google review form opens — <strong>no searching, no typing</strong>. This removes the single biggest drop-off point.</p><h2>Reply in the customer\'s language</h2><p>Customers in India review in Hindi, Marathi, Tamil, Telugu, Bengali, and Hinglish. Replying in the same language feels personal and earns more engagement. Where the tone is friendly and local, Google rewards response rate and customers notice.</p><h2>Stay policy-safe</h2><ul><li>Never buy, incentivise, or ask a group to leave reviews at once</li><li>Never post reviews from your own device for your business</li><li>Never filter to only ask happy customers if it looks manipulative</li><li>Do reply to every review — positive and negative — promptly</li></ul><h2>Untab\'s review engine</h2><p>Untab gives you a <strong>direct review link</strong> and a <strong>printable QR stand</strong> per location, plus an AI assistant that drafts on-brand replies in Hindi and English. Manage every review across all branches from one feed.</p>',
            ],
            [
                'title' => 'Google Maps Ranking in India: The Factors That Actually Matter in 2026',
                'slug' => 'google-maps-ranking-india-factors-2026',
                'excerpt' => 'Relevance, distance, and prominence — plus Indian nuances like pin-code service areas and vernacular keywords. Here is what really moves a business up the India map pack.',
                'category' => 'India',
                'author' => 'Untab Team',
                'featured' => false,
                'status' => 'published',
                'tags' => ['india', 'google-maps', 'mpack-ranking', 'local-seo'],
                'keywords' => 'Google Maps ranking India, local pack India, GBP ranking factors, Indian local SEO, map ranking 2026',
                'meta_title' => 'Google Maps Ranking in India: What Matters in 2026 | Untab',
                'meta_description' => 'The Google Maps local-pack factors that matter for Indian businesses: relevance, distance, prominence, pin-code service areas, and vernacular keywords in 2026.',
                'cover_image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1200&q=80',
                'content' => '<p>Everyone wants to be in the Google Maps "local pack" — the three businesses shown under the map for a local search. In India the winners are rarely the biggest brands; they are the ones who nail three levers.</p><h2>1. Relevance</h2><p>Relevance is how well your profile matches what the customer searched. Choose a <strong>precise primary category</strong> and add every relevant secondary category, service, and attribute. A dental clinic should list <em>Teeth Whitening</em>, <em>Root Canal</em>, and <em>Dental Implants</em> — not just "Healthcare".</p><h2>2. Distance</h2><p>Google uses your physical address and pin-code. For home-serve businesses — electricians, plumbers, tutors — set a clear <strong>service area</strong> and let Google weight proximity to the customer\'s pin code.</p><h2>3. Prominence</h2><p>Prominence is the hardest and most valuable: it is the sum of your <strong>reviews</strong>, your <strong>response rate</strong>, your <strong>Google Posts</strong>, your web <strong>NAP consistency</strong>, and your authority. This is where most Indian businesses leave points on the board.</p><blockquote>Profiles that answer 100% of reviews and post weekly consistently outrank similar businesses with more reviews but no engagement.</blockquote><h2>Indian nuances to watch</h2><ul><li>Vernacular keywords (Hindi, Hinglish) are searched and must appear in your description and posts</li><li>Pin-code level service areas beat "city-level" every time</li><li>Photo freshness (food, interiors, teams) signals an active business</li><li>N-A-P (Name, Address, Phone) must be identical on your site, GBP, and across the web</li></ul><h2>Track it with Untab</h2><p>Untab pulls your calls, directions, clicks and bookings per location, plus Google Search Console queries — so you can see exactly which keywords move and double down.</p>',
            ],
            [
                'title' => 'Google Posts for Indian Festivals: Diwali, Holi & Offer Schedules That Convert',
                'slug' => 'google-posts-indian-festivals-diwali-holi-offers',
                'excerpt' => 'Indian festivals are local shopping seasons. Learn to schedule Diwali, Holi, Raksha Bandhan, and Independence Day offers and event posts across all your branches in one click.',
                'category' => 'India',
                'author' => 'Untab Team',
                'featured' => true,
                'status' => 'published',
                'tags' => ['india', 'google-posts', 'festival-marketing', 'diwali'],
                'keywords' => 'Google Posts India, Diwali offer post, festival Google Posts, Holi offer, Indian franchise marketing',
                'meta_title' => 'Google Posts for Indian Festivals: Diwali, Holi & More | Untab',
                'meta_description' => 'Schedule Diwali, Holi, and Raksha Bandhan offers and event Google Posts across all your Indian branches in one click, with coupon codes and live preview.',
                'cover_image' => 'https://images.unsplash.com/photo-1514222134-b57cbb8ce073?auto=format&fit=crop&w=1200&q=80',
                'content' => '<p>Indian festivals are the highest-converting local seasons of the year. Diwali, Holi, Raksha Bandhan, and Independence Day drive massive footfall — and a <strong>Google Post</strong> is the cheapest way to capture it.</p><h2>Why festival posts win</h2><p>Google Posts appear directly on your Business Profile in Maps and Search. A well-timed festival offer — with a coupon code and a clear call to action — turns someone who is merely browsing into a customer who walks in.</p><blockquote>Profiles that publish seasonal offers see a measurable lift in profile clicks and bookings during the festival window.</blockquote><h2>Which post types to use</h2><ul><li><strong>Offer posts:</strong> "Diwali Dhamaka — Flat 20% Off" with a coupon code and valid dates</li><li><strong>Event posts:</strong> Holi party, Diwali mela, free health camp, store reopening</li><li><strong>Update posts:</strong> Festival hours, special menu, new stock, late-night shopping</li></ul><h2>Schedule across every branch</h2><p>A single head-office post can be pushed to all your locations in seconds. Keep the brand offer consistent (flat discount), then let each branch add a local touch — a store-specific time or a local holiday message in the regional language.</p><h2>Best practices</h2><ul><li>Publish 3–5 days before the festival, not on the day</li><li>Use a square 1200×1200 festive image</li><li>Include a clear CTA: Book, Call, Order, Visit</li><li>Update your festival hours on every profile</li></ul><h2>Untab\'s festival scheduler</h2><p>Untab lets you create a festival Google Post, pick any subset of branches (or all of them), and schedule it automatically. One click, every location, in time for the season.</p>',
            ],
            [
                'title' => 'Multi-Location Google Business Profile Management for Indian Franchises & Chains',
                'slug' => 'multi-location-gbp-management-india-franchise',
                'excerpt' => 'Indian food chains, clinics, coaching institutes and salons are expanding fast. Here is how to manage 10–500+ Google Business Profiles consistently from one dashboard.',
                'category' => 'India',
                'author' => 'Untab Team',
                'featured' => true,
                'status' => 'published',
                'tags' => ['india', 'multi-location', 'franchise', 'chain'],
                'keywords' => 'multi-location Google Business Profile India, franchise GBP management, Indian chain local SEO, coaching institute maps',
                'meta_title' => 'Multi-Location GBP Management for Indian Franchises | Untab',
                'meta_description' => 'Manage Google Business Profiles for 10 to 500+ Indian branches — restaurants, clinics, salons, coaching institutes — from one dashboard with consistent branding.',
                'cover_image' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=1200&q=80',
                'content' => '<p>Indian franchises are scaling faster than ever — food chains, dental clinics, salons, gyms, and coaching institutes (yes, the <strong>coaching centre</strong> that ranks for "best JEE coaching near me" is a maps battle). Each new branch is another Google Business Profile to manage.</p><h2>The tab-switching problem</h2><p>With 20 branches and 5 daily tasks each, that is 100 logins and tab-switches a day. At 100 branches, it is 500. It does not scale — but a <strong>centralised dashboard</strong> does.</p><h2>What a franchise actually needs</h2><ul><li>See every branch\'s key health metric on one screen</li><li>Group branches by region, city, or line of business</li><li>Push one offer or festival post to all branches at once</li><li>Keep reviews, replies, and media brand-consistent</li><li>Let store managers access only their own branch</li></ul><h2>Consistency is the franchise superpower</h2><p>Google rewards a coherent network. The same brand name, same categories, same offer messaging, and a <strong>fast response to every review</strong> across branches signals an active, trustworthy business — and lifts the whole network.</p><blockquote>Franchises that benchmark branches side-by-side spot their worst performers and fix them before they drag the brand down.</blockquote><h2>Untab for Indian chains</h2><p>Untab gives you a multi-location command centre: publish posts to hundreds of branches in one click, reply to reviews with AI in Hindi and English, and compare every branch\'s calls, directions and clicks side-by-side.</p>',
            ],
            [
                'title' => 'Google Business Profile for Indian Doctors & Clinics: Patient Acquisition in 2026',
                'slug' => 'google-business-profile-indian-doctors-clinics',
                'excerpt' => 'Indian patients search for doctors on Google Maps before they book. Here is how clinics and doctors can rank, collect reviews, and convert searches into appointments.',
                'category' => 'India',
                'author' => 'Untab Team',
                'featured' => false,
                'status' => 'published',
                'tags' => ['india', 'healthcare', 'doctors', 'clinics'],
                'keywords' => 'Google Business Profile doctors India, clinic local SEO, patient acquisition India, doctor appointment through Maps',
                'meta_title' => 'Google Business Profile for Indian Doctors & Clinics | Untab',
                'meta_description' => 'How Indian doctors and clinics can rank on Google Maps, collect patient reviews, and turn local searches into booked appointments in 2026.',
                'cover_image' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=1200&q=80',
                'content' => '<p>When a patient in India feels unwell, they open Google Maps and search <em>"nearby doctor"</em>, <em>"dentist in my area"</em>, or <em>"best physiotherapist near me"</em>. If your clinic is not on the map pack, your competitor is.</p><h2>Why healthcare wins on GBP</h2><p>Healthcare is a trust decision, and patients judge trust by <strong>reviews</strong> and <strong>profile completeness</strong>. A clinic with 200+ reviews and a 4.9 rating will get the booking far more often than a clinic with a bare listing.</p><h2>Set up your clinic profile right</h2><ul><li>Primary category: <strong>Dentist</strong>, <strong>Doctor</strong>, <strong>Physiotherapist</strong> — not "Health"</li><li>Add services: root canal, pediatric care, teleconsultation, home visit</li><li>Add <strong>appointment booking</strong> and <strong>online consultation</strong> timings</li><li>List every doctor with their speciality on a single profile</li><li>Post weekly health tips and free-camp events</li></ul><blockquote>80% of local healthcare searches in India happen on mobile, and most lead to a call or a visit within a day. You cannot afford to be invisible.</blockquote><h2>Reviews and response time</h2><p>Ask satisfied patients to leave a review at the front desk via a counter QR code and a WhatsApp link. Reply to every review — a thank you in the patient\'s language builds trust, and a prompt reply to a complaint signals professionalism to prospective patients.</p><h2>Untab for healthcare</h2><p>Untab helps clinics manage reviews across branches, schedule health-camp event posts, and track calls and directions so you know which services drive patients.</p>',
            ],
            [
                'title' => 'Claim & Verify Your Google Business Profile in India: Step-by-Step for 2026',
                'slug' => 'claim-verify-google-business-profile-india-2026',
                'excerpt' => 'Verification is the #1 blocker for Indian businesses. Here is how to claim your profile, verify by phone, video or postcard, and fix the common rejections.',
                'category' => 'India',
                'author' => 'Untab Team',
                'featured' => false,
                'status' => 'published',
                'tags' => ['india', 'gbp-verification', 'claim-profile', 'how-to'],
                'keywords' => 'verify Google Business Profile India, claim GBP, Google verification video India, GBP rejection fix',
                'meta_title' => 'Claim & Verify Your Google Business Profile in India | Untab',
                'meta_description' => 'How Indian businesses claim and verify their Google Business Profile by phone, video, or postcard — plus how to fix the most common verification rejections in 2026.',
                'cover_image' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?auto=format&fit=crop&w=1200&q=80',
                'content' => '<p>You cannot rank on Google Maps until you <strong>verify</strong> your Business Profile. Verification is where many Indian businesses get stuck — here is how to clear it quickly.</p><h2>Step 1: Claim your profile</h2><p>Go to business.google.com and search for your business. If it appears, request ownership. If it doesn\'t, create a new listing. Choose the right <strong>category</strong> and add a name that matches your real signage.</p><h2>Step 2: Choose your verification method</h2><ul><li><strong>Phone or SMS:</strong> Fastest for most Indian businesses. You get a code on your registered number.</li><li><strong>Email:</strong> Used when your domain is tied to Google services.</li><li><strong>Video:</strong> Ideal for service-area or home-based businesses. Record your storefront, signage, and business-only documents on video.</li><li><strong>Postcard:</strong> Google postcards are often slow in India and can be declined by couriers. Prefer phone or video.</li></ul><h2>Step 3: Fix the common rejections</h2><ul><li>Name doesn\'t match your real signage — keep it exact</li><li>Address points to a residential flat with no public signage</li><li>Category is too generic — choose the specific one</li><li>Photos show a different business or are watermarked stock</li></ul><blockquote>Verification is a one-time gate. Get it right and you own the listing; get it wrong and you risk a suspension.</blockquote><h2>After you verify</h2><p>Complete the profile 100%: hours, services, service area, photos, and a description in your local language. Then start collecting reviews and posting Google Posts — a verified, active, and reviewed profile is what ranks.</p><h2>Manage it at scale with Untab</h2><p>Once verified, Untab keeps every branch\'s profile fresh — reviews answered, offers scheduled, and insights tracked — from one dashboard.</p>',
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::updateOrCreate(
                ['slug' => $post['slug']],
                $post
            );
        }
    }
}
