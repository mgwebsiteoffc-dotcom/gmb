# Untab - Google Business Profile Platform in Laravel 12

A complete, full-featured replica of **[Untab](https://www.untab.com/)** built from the ground up in **Laravel 12**, **Blade**, **Tailwind CSS**, and **SQLite**.

---

## 🚀 Key Modules & Features Implemented

### 1. 🏢 Multi-Location Command Center (`/app/dashboard`)
- Manage 10 to 500+ Google Business Profiles without tab-switching.
- Client Portfolio & Location Scope selector with live data aggregation.
- Top KPI Scorecards: Total GBP Profile Views, Direct Phone Calls, Direction Requests, Website Clicks, and Review Health score.
- Location Health Matrix with Google verification badges and one-click deep dive insights.
- Pending review queues & scheduled posts preview.

### 2. 💬 Google Reviews & AI Reply Assistant (`/app/reviews`)
- Unified multi-location review feed with instant filtering by:
  - Star Rating (1-5★)
  - Customer Sentiment (Positive, Neutral, Negative)
  - Status (🔴 Needs Reply vs 🟢 Replied)
  - Keyword search
- **AI Review Reply Generator (`AiAssistantService`)**:
  - Tone strategies: **Warm & Friendly**, **Professional**, **SEO Keyword Rich**, and **Empathetic / Apology**.
  - Local keyword injection for SEO advantage.
  - One-click reply posting and live status updates.
- **Bulk AI Reply Engine**: One-click automation to draft and publish replies to all pending reviews.

### 3. 📢 Google Posts Scheduler & Publisher (`/app/posts`)
- Broadcast updates, offers with coupon codes, and events across single or multiple locations simultaneously.
- **AI Post Caption Writer**: Generates high-converting promotional copy and CTAs.
- **Live Google Maps & Search Card Preview**: Visualizes how posts will appear to customers before publishing.
- Call-to-action button selectors: *Book, Order Online, Buy, Learn More, Sign Up, Call Now*.
- Post views and CTA click analytics tracking.

### 4. 📈 GBP Performance Insights & Analytics (`/app/insights`)
- Google Maps vs Google Search impressions trend (interactive Chart.js line charts).
- Customer Conversion Actions: Phone Calls, Direction Requests, and Website Visits (Chart.js bar charts).
- Date range filtering (*7d, 30d, 90d, 12m*).
- Cross-location benchmarking comparison matrix.

### 5. 🔍 Google Search Console Built-In (`/app/search-console`)
- Synced organic website keywords, impressions, clicks, CTR, and average position alongside GBP metrics.
- Top landing pages analysis.
- Device distribution breakdown (*Mobile 74%, Desktop 23%, Tablet 3%*).

### 6. 📸 Media Asset Manager & Geotagging (`/app/media`)
- Categorized photo gallery (*Interior, Exterior, Team & Staff, Food / Product, Cover*).
- Multi-location photo broadcast.
- **GPS EXIF Geotagging Simulator**: Injects location coordinates and keyword metadata into photo uploads.

### 7. 📄 White-Label Client Reports (`/app/reports`)
- Agency white-label customizer: Agency logo, custom brand accent color, custom executive summary notes, client selector.
- Live client-ready paper preview.
- **1-Click PDF Report Export**: Generated directly with `jsPDF`.
- Shareable client link generator.

### 8. 👥 Team & Granular Permissions (`/app/team`)
- Role-based access control (*Account Director, Local SEO Specialist, Content Manager, Client View-Only*).
- Granular module permission toggles (*Posts, Reviews, Media, Reports*).

### 9. 🔗 Google Account Connection & Client Groups (`/app/connect`)
- Simulated Google OAuth sync flow to link new Google Business Profiles.
- Group locations into client portfolios.

### 10. ⚙️ Agency Settings (`/app/settings`)
- Custom domain / subdomain configuration (`clients.youragency.com`).
- Instant negative review email alerts and weekly digest settings.

---

## 🔐 Authentication (Production)

Real **register / login / logout** flows using Laravel's `Auth` guard (`User` model). The marketing site is public; the `/app` workspace is front-and-centre for the demo and can be gated with the `auth` middleware for production.

---

## 🤖 AI (OpenRouter) Integration

The AI Review Reply and Google Post Caption engines are powered by **OpenRouter** chat completions (matching the reference Python flow that preserves `reasoning_details`):

- `app/Services/OpenRouterService.php` — thin HTTP client over `POST /chat/completions` with `reasoning: { enabled: true }`.
- `app/Services/AiAssistantService.php` — builds tone-aware, sentiment-aware prompts and returns strict JSON for post captions.
- **Graceful fallback:** if `OPENROUTER_API_KEY` is empty or the request fails, Untab falls back to its built-in template generator so every panel keeps working.
- Model default: `nvidia/nemotron-3.5-lightning:free`.

Configure in `.env`:

```bash
OPENROUTER_API_KEY=your_key
OPENROUTER_MODEL="nvidia/nemotron-3.5-lightning:free"
OPENROUTER_BASE_URL="https://openrouter.ai/api/v1"
OPENROUTER_REASONING=true
OPENROUTER_TIMEOUT=60
```

---

## 🛠️ Free SEO Tools Suite Included

1. **GBP 16-Point Audit & Health Score Tool** (`/google-business-profile-audit-tool`)
2. **Direct Google Review Link Generator** (`/google-review-link`)
3. **Printable Review QR Code & Stand Card Maker** (`/google-review-qr-code`)
4. **Tap-to-Review NFC Smart Card Configurator** (`/google-review-card`)
5. **GBP Photo Dimensions & Guidelines Guide** (`/google-business-profile-photo-size`)

---

## 🔎 SEO / AEO / JSON-LD (everywhere)

- **Central SEO partial** (`resources/views/partials/seo.blade.php`): title, meta description, keywords, canonical, robots, Open Graph, Twitter Card, geo/local SEO meta, favicon, manifest.
- **Structured data (JSON-LD):** `Organization`, `WebSite`, `SoftwareApplication` (global); `FAQPage` (marketing + tools pages); `LocalBusiness` + `AggregateRating` + `BreadcrumbList` (location pages); `Product`/`AggregateOffer` (pricing).
- **FAQ sections** on home, features, audit tool, review link, QR code, NFC card, photo guide, agency, and multi-location pages.
- **Dynamic `/sitemap.xml`** (all pages + every location) and **`/robots.txt`**.

---

## 💻 Tech Stack & Architecture

- **Backend**: Laravel 12 (PHP 8.4)
- **Database**: SQLite with Eloquent Relationships (`Client`, `Location`, `Review`, `Post`, `MediaItem`, `SearchQuery`, `SearchPage`, `TeamMember`, `AgencySetting`)
- **Frontend**: Laravel Blade Templates + Tailwind CSS + Alpine.js + Lucide Icons
- **Interactive Libraries**: Chart.js, QRCode.js, jsPDF
- **AI**: OpenRouter chat completions

---

## 🏃 Running the Application

```bash
cd untab
composer install
cp .env.example .env && php artisan key:generate
npm install
npm run build
php artisan migrate --seed
php artisan storage:link
php artisan serve --host=0.0.0.0 --port=8000
```

> **Important**: use `composer install` (or `composer update`) **without** `--prefer-source`. The framework must be fetched as a **dist** package or it will be missing the compiled exception-renderer assets. See [FIXING-ERRORS.md](FIXING-ERRORS.md) if you hit `...exceptions/renderer/dist/styles.css: Failed to open stream`.

---

## 🛡️ Super Admin / SaaS Owner Panel (`/admin`)

A full role-based admin panel for the platform owner (Super Admin), guarded by the `role` middleware:

- **Platform dashboard** — live KPIs (clients, locations, users, reviews, posts), monthly growth chart, role distribution, recent users & brands.
- **Users & Roles** — create/edit/deactivate/delete Super Admins, Brand Admins, and staff; assign Brand Admins to a client; search & filter by role.
- **Brands & Clients** — full CRUD for each client/brand, per-brand KPIs (reviews, views, ratings), location lists, and assigned Brand Admins.
- **Platform Settings** — agency name, custom domain, brand color, support email, and the default OpenRouter AI model.

**Roles:**
| Role | Access |
|------|--------|
| `super_admin` | Full platform access (`/admin`, everything) |
| `brand_admin` | Scoped to one client/brand (`client_id`) |
| `user` | Standard agency staff |

**Demo accounts (seeded by `DatabaseSeeder` → `UserSeeder`):** all passwords are `password123` unless noted.

| Email | Role |
|-------|------|
| `owner@untab.com` | Super Admin (SaaS owner) |
| `admin@untab.com` | Super Admin |
| `apex@untab.com` / `urban@untab.com` / `horizon@untab.com` / `elevate@untab.com` | Brand Admins |
| `sarah@untab.com` / `marcus@untab.com` / `elena@untab.com` / `leo@untab.com` | Users / Staff |

Seeders live in `database/seeders/`:
- `UserSeeder` — super admin, brand admins, staff
- `TeamSeeder` — demo team members (assigned to clients, role permissions)
- `DatabaseSeeder` — the full demo dataset (clients, locations, reviews, posts, media, search console, settings)
