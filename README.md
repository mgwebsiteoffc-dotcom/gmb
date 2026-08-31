# Ampli5 Pulse - Google Business Profile Platform in Laravel 12

A complete, full-featured replica of **[Ampli5 Pulse](https://www.ampli5pulse.com/)** built from the ground up in **Laravel 12**, **Blade**, **Tailwind CSS**, and **SQLite**.

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

## 🛠️ Free SEO Tools Suite Included

1. **GBP 16-Point Audit & Health Score Tool** (`/google-business-profile-audit-tool`)
2. **Direct Google Review Link Generator** (`/google-review-link`)
3. **Printable Review QR Code & Stand Card Maker** (`/google-review-qr-code`)
4. **Tap-to-Review NFC Smart Card Configurator** (`/google-review-card`)
5. **GBP Photo Dimensions & Guidelines Guide** (`/google-business-profile-photo-size`)

---

## 💻 Tech Stack & Architecture

- **Backend**: Laravel 12 (PHP 8.4)
- **Database**: SQLite with Eloquent Relationships (`Client`, `Location`, `Review`, `Post`, `MediaItem`, `SearchQuery`, `SearchPage`, `TeamMember`, `AgencySetting`)
- **Frontend**: Laravel Blade Templates + Tailwind CSS + Alpine.js + Lucide Icons
- **Interactive Libraries**: Chart.js, QRCode.js, jsPDF

---

## 🏃 Running the Application

```bash
cd ampli5-pulse-laravel
php artisan migrate --seed
php artisan serve --host=0.0.0.0 --port=8000
```
