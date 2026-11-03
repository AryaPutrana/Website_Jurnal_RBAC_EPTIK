# 📋 RENCANA UPGRADE WEBSITE JURNAL ILMIAH
## 3 Tahap Peningkatan Kualitas & Fitur

**Project:** Website Jurnal Ilmiah EPTIK
**Database:** DB_Eptik
**Framework:** Laravel 10.50.4
**Tanggal:** 03 November 2026

---

## 🎯 ANALISIS KONDISI SAAT INI

### ✅ Sudah Ada (Completed):
- [x] Authentication system (Admin & User)
- [x] Article management (CRUD)
- [x] Category management
- [x] Submission system (User submit → Admin review)
- [x] PDF upload (max 10MB)
- [x] Public frontend (Homepage, Articles, Detail, About)
- [x] Search & filter articles
- [x] Responsive design (Mobile, Tablet, Desktop)
- [x] Security (CSRF, XSS, SQL injection protection, rate limiting)
- [x] Custom error pages (403, 404)
- [x] Form validation

### 🔍 Yang Perlu Ditingkatkan:
1. **Fitur Publishing**
   - Belum ada DOI (Digital Object Identifier)
   - Belum ada citation format
   - Belum ada article statistics (views, downloads)

2. **User Experience**
   - Belum ada notification system
   - Belum ada email notification
   - Belum ada dashboard statistics charts
   - Belum ada article preview sebelum submit

3. **Content Management**
   - Belum ada rich text editor untuk abstract
   - Belum ada article versioning
   - Belum ada peer review system (advanced)
   - Belum ada comment/feedback system

4. **SEO & Performance**
   - Belum ada meta tags optimization
   - Belum ada sitemap.xml
   - Belum ada image optimization
   - Belum ada caching strategy

5. **Admin Tools**
   - Belum ada export reports (Excel, PDF)
   - Belum ada bulk actions
   - Belum ada activity log
   - Belum ada advanced analytics

---

## 🚀 TAHAP 1: PENINGKATAN FITUR DASAR (Priority High)
**Target:** Meningkatkan fungsionalitas inti dan user experience
**Estimasi:** 3-5 hari
**Difficulty:** Medium

### 1.1 EMAIL NOTIFICATION SYSTEM ⭐⭐⭐⭐⭐
**Kenapa penting:** User dan admin perlu notifikasi real-time

**Fitur:**
- ✉️ Email saat artikel di-submit (ke Admin)
- ✉️ Email saat artikel di-approve/reject (ke User)
- ✉️ Email welcome untuk user baru
- ✉️ Email reset password (sudah ada form, perlu konfigurasi)
- ✉️ Email reminder untuk pending submissions

**Tech Stack:**
- Laravel Mail & Mailables
- Queue system (database atau sync)
- Email templates dengan design matching website

**Files to create:**
```
app/Mail/ArticleSubmitted.php
app/Mail/ArticleApproved.php
app/Mail/ArticleRejected.php
app/Mail/WelcomeUser.php
resources/views/emails/article-submitted.blade.php
resources/views/emails/article-approved.blade.php
resources/views/emails/article-rejected.blade.php
resources/views/emails/welcome.blade.php
```

**Config:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@jurnal.com
MAIL_FROM_NAME="Jurnal Ilmiah"
```

---

### 1.2 ARTICLE STATISTICS & VIEWS COUNTER ⭐⭐⭐⭐
**Kenapa penting:** Menampilkan popularitas artikel, berguna untuk research impact

**Fitur:**
- 📊 View counter setiap artikel dibuka
- 📥 Download counter setiap PDF di-download
- 📈 Most viewed articles (homepage & admin dashboard)
- 📉 Article statistics per category
- 🏆 Top 5 popular articles widget

**Database Migration:**
```sql
CREATE TABLE article_views (
    id BIGINT PRIMARY KEY,
    article_id BIGINT (foreign key),
    user_id BIGINT (nullable, foreign key),
    ip_address VARCHAR(45),
    user_agent TEXT,
    viewed_at TIMESTAMP,
    created_at TIMESTAMP
);

ALTER TABLE articles ADD COLUMN views_count INT DEFAULT 0;
ALTER TABLE articles ADD COLUMN downloads_count INT DEFAULT 0;
```

**Features:**
- Track unique views (by IP dalam 24 jam)
- Track downloads dengan logging
- Display views badge di article card
- Admin dashboard: Chart statistik views

---

### 1.3 RICH TEXT EDITOR (TinyMCE / Quill) ⭐⭐⭐⭐
**Kenapa penting:** Abstract dan content lebih rapi dengan formatting

**Fitur:**
- 📝 Rich text editor untuk Abstract
- 📝 Rich text editor untuk Article Content (optional)
- ✅ Bold, Italic, Underline
- ✅ Bullet lists, numbered lists
- ✅ Links, quotes
- ✅ Paste from Word (clean HTML)

**Tech Stack:**
- TinyMCE 6 (recommended) atau Quill.js
- Image upload support (optional)

**Integration:**
```html
<script src="https://cdn.tiny.cloud/1/YOUR_API_KEY/tinymce/6/tinymce.min.js"></script>
<script>
tinymce.init({
    selector: '#abstract',
    height: 300,
    plugins: 'lists link paste',
    toolbar: 'bold italic underline | bullist numlist | link'
});
</script>
```

---

### 1.4 ARTICLE PREVIEW (Before Submit) ⭐⭐⭐
**Kenapa penting:** User bisa review artikel sebelum submit

**Fitur:**
- 👁️ Preview button di form submission
- 📄 Modal popup dengan preview layout
- ✅ Show: Title, Authors, Category, Abstract, Keywords
- ✅ PDF preview (iframe atau link)
- ✅ Edit button untuk kembali ke form

**Implementation:**
- JavaScript modal dengan Bootstrap
- Format preview matching article detail page
- Validation sebelum preview (required fields)

---

### 1.5 NOTIFICATION BELL (In-App Notification) ⭐⭐⭐
**Kenapa penting:** Real-time notification tanpa harus cek email

**Fitur:**
- 🔔 Notification bell icon di navbar
- 🔴 Red badge counter (unread)
- 📬 Dropdown list notifikasi
- ✅ Mark as read
- 🗑️ Clear all notifications

**Database Migration:**
```sql
CREATE TABLE notifications (
    id BIGINT PRIMARY KEY,
    user_id BIGINT (foreign key),
    type VARCHAR(50), -- 'submission', 'approval', 'rejection'
    title VARCHAR(255),
    message TEXT,
    link VARCHAR(255),
    is_read BOOLEAN DEFAULT false,
    created_at TIMESTAMP
);
```

**Types:**
- Admin: "Artikel baru submitted: [Title]"
- User: "Artikel Anda disetujui: [Title]"
- User: "Artikel Anda ditolak: [Title]"

---

### 1.6 DASHBOARD STATISTICS CHARTS ⭐⭐⭐⭐
**Kenapa penting:** Visual analytics untuk admin & user

**Admin Dashboard:**
- 📊 Line chart: Submissions per month (last 6 months)
- 📊 Pie chart: Articles by category
- 📊 Bar chart: Submission status (Pending, Approved, Rejected)
- 📊 Area chart: Views trend (last 30 days)

**User Dashboard:**
- 📊 Donut chart: My submissions status
- 📊 Line chart: My article views trend

**Tech Stack:**
- Chart.js (lightweight & responsive)
- ApexCharts (modern & interactive) - RECOMMENDED

**Example:**
```html
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<div id="submissions-chart"></div>
<script>
var options = {
    chart: { type: 'line' },
    series: [{ name: 'Submissions', data: [10, 15, 20, 18, 25, 30] }],
    xaxis: { categories: ['Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov'] }
};
var chart = new ApexCharts(document.querySelector("#submissions-chart"), options);
chart.render();
</script>
```

---

### 1.7 ADVANCED SEARCH & FILTERS ⭐⭐⭐
**Kenapa penting:** User bisa cari artikel lebih spesifik

**Current:** Search by title/keywords only

**Upgrade:**
- 🔍 Search by: Title, Authors, Abstract, Keywords (combined)
- 📅 Filter by date range (publication date)
- 📁 Filter by multiple categories (checkbox)
- 🔢 Sort by: Latest, Oldest, Most Viewed, Most Downloaded
- 🎯 Advanced search modal dengan multiple criteria

**UI:**
- Advanced search button → open modal
- Filter sidebar di articles page
- Active filters badge (removable)
- Clear all filters button

---

## 📊 TAHAP 1 SUMMARY

| No | Feature | Priority | Difficulty | Estimasi |
|----|---------|----------|------------|----------|
| 1.1 | Email Notifications | ⭐⭐⭐⭐⭐ | Medium | 1 hari |
| 1.2 | Article Statistics | ⭐⭐⭐⭐ | Easy | 0.5 hari |
| 1.3 | Rich Text Editor | ⭐⭐⭐⭐ | Easy | 0.5 hari |
| 1.4 | Article Preview | ⭐⭐⭐ | Easy | 0.5 hari |
| 1.5 | Notification Bell | ⭐⭐⭐ | Medium | 1 hari |
| 1.6 | Dashboard Charts | ⭐⭐⭐⭐ | Medium | 1 hari |
| 1.7 | Advanced Search | ⭐⭐⭐ | Easy | 0.5 hari |

**Total Estimasi:** 5 hari (tanpa error)

**Impact:** ⭐⭐⭐⭐⭐ (Sangat meningkatkan UX dan profesionalisme)

---

## 🎨 TAHAP 2: PENINGKATAN KUALITAS & PROFESIONALISME (Priority Medium)
**Target:** Fitur profesional untuk jurnal ilmiah
**Estimasi:** 4-6 hari
**Difficulty:** Medium-Hard

### 2.1 DOI (DIGITAL OBJECT IDENTIFIER) GENERATOR ⭐⭐⭐⭐⭐
**Kenapa penting:** Jurnal ilmiah profesional wajib punya DOI

**Fitur:**
- 🔗 Auto-generate DOI saat artikel di-approve
- 📋 Format: `10.xxxxx/jurnal.YYYY.MM.NNN`
- 🔢 Sequential number per tahun
- 💾 Store di database
- 📄 Display di article detail page
- 📑 Include di PDF metadata

**Database Migration:**
```sql
ALTER TABLE articles ADD COLUMN doi VARCHAR(100) UNIQUE;
ALTER TABLE articles ADD COLUMN doi_generated_at TIMESTAMP;
```

**DOI Format Example:**
```
10.12345/jurnal.2026.11.001
10.12345/jurnal.2026.11.002
10.12345/jurnal.2026.12.001
```

**Note:** DOI asli butuh registrasi ke CrossRef ($275/tahun), tapi untuk demo/internal bisa pakai format custom.

---

### 2.2 CITATION FORMATS ⭐⭐⭐⭐⭐
**Kenapa penting:** Researcher perlu cite artikel dengan format standard

**Fitur:**
- 📖 APA Format
- 📖 MLA Format
- 📖 IEEE Format
- 📖 Harvard Format
- 📖 Chicago Format
- 📖 BibTeX Format
- 📋 Copy to clipboard button
- 📥 Export citation (.bib file)

**Example - APA:**
```
Penulis, A., & Penulis, B. (2026). Judul Artikel. Jurnal Ilmiah, Volume(Issue), Pages. https://doi.org/10.xxxxx/jurnal.2026.11.001
```

**Example - BibTeX:**
```bibtex
@article{penulis2026,
    title={Judul Artikel},
    author={Penulis, A. and Penulis, B.},
    journal={Jurnal Ilmiah},
    year={2026},
    volume={1},
    number={1},
    pages={1--10},
    doi={10.xxxxx/jurnal.2026.11.001}
}
```

**Implementation:**
- Citation modal di article detail
- PHP class CitationFormatter
- JavaScript copy to clipboard

---

### 2.3 EXPORT REPORTS (Admin Tools) ⭐⭐⭐⭐
**Kenapa penting:** Admin perlu laporan untuk evaluasi

**Fitur:**
- 📊 Export submissions report (Excel)
- 📊 Export articles report (Excel)
- 📊 Export statistics report (PDF)
- 📅 Filter by date range
- 📁 Filter by category
- 📈 Include charts dalam PDF

**Reports:**
1. **Submissions Report**
   - All submissions dengan status
   - Kolom: ID, Title, User, Category, Status, Date
   - Export: Excel (.xlsx)

2. **Articles Report**
   - Published articles dengan statistik
   - Kolom: DOI, Title, Authors, Category, Views, Downloads, Date
   - Export: Excel (.xlsx)

3. **Monthly Statistics**
   - Summary per bulan
   - Include charts
   - Export: PDF

**Tech Stack:**
- Laravel Excel (Maatwebsite)
- DomPDF (untuk PDF dengan charts)

**Installation:**
```bash
composer require maatwebsite/excel
composer require barryvdh/laravel-dompdf
```

---

### 2.4 ARTICLE VERSIONING ⭐⭐⭐
**Kenapa penting:** Track perubahan artikel (revisi)

**Fitur:**
- 📝 Version history untuk setiap artikel
- 🔄 Admin bisa request revision (reject dengan catatan)
- ✍️ User submit revised version
- 📂 Keep all versions (PDF)
- 📊 Display version number: v1.0, v1.1, v2.0

**Database Migration:**
```sql
CREATE TABLE article_versions (
    id BIGINT PRIMARY KEY,
    article_id BIGINT (foreign key),
    version VARCHAR(10), -- 'v1.0', 'v1.1'
    pdf_path VARCHAR(255),
    changes_summary TEXT,
    created_by BIGINT (foreign key to users),
    created_at TIMESTAMP
);
```

**Workflow:**
1. User submit article → v1.0
2. Admin reject dengan request revision
3. User edit & re-submit → v1.1
4. Admin approve → Published
5. Jika ada correction → v1.2, v2.0 (major change)

---

### 2.5 PEER REVIEW SYSTEM (Simple) ⭐⭐⭐⭐
**Kenapa penting:** Meningkatkan kualitas artikel

**Fitur:**
- 👥 Admin assign reviewer (user dengan role 'reviewer')
- 📝 Reviewer submit review (approve/reject/revise)
- 💬 Review notes untuk author
- ⭐ Rating system (1-5 stars)
- 📊 Track review status

**Database Migration:**
```sql
-- Add new role
UPDATE users SET role = 'reviewer' WHERE email = 'reviewer@jurnal.com';

CREATE TABLE reviews (
    id BIGINT PRIMARY KEY,
    article_id BIGINT (foreign key),
    reviewer_id BIGINT (foreign key to users),
    status ENUM('pending', 'approved', 'rejected', 'needs_revision'),
    rating INT(1-5),
    notes TEXT,
    reviewed_at TIMESTAMP,
    created_at TIMESTAMP
);
```

**Workflow:**
1. Admin assign 1-3 reviewers per article
2. Reviewer dashboard: Assigned articles
3. Reviewer review artikel & submit feedback
4. Admin lihat semua reviews
5. Admin decide: Approve / Reject / Request Revision

---

### 2.6 SEO OPTIMIZATION ⭐⭐⭐⭐
**Kenapa penting:** Website mudah ditemukan di Google

**Fitur:**
- 🔍 Meta tags optimization (title, description, keywords)
- 🗺️ Sitemap.xml (auto-generated)
- 🤖 Robots.txt
- 📱 Open Graph tags (Facebook, Twitter)
- 🔗 Schema.org markup (ScholarlyArticle)
- 🌐 Canonical URLs

**Meta Tags Example:**
```html
<meta name="description" content="Baca artikel ilmiah: {{ $article->title }}">
<meta name="keywords" content="{{ $article->keywords }}">
<meta name="author" content="{{ $article->authors }}">

<!-- Open Graph -->
<meta property="og:title" content="{{ $article->title }}">
<meta property="og:description" content="{{ Str::limit($article->abstract, 150) }}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{ route('articles.show', $article->slug) }}">

<!-- Schema.org -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ScholarlyArticle",
  "headline": "{{ $article->title }}",
  "author": "{{ $article->authors }}",
  "datePublished": "{{ $article->publication_date }}"
}
</script>
```

**Sitemap.xml:**
```xml
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc>https://jurnal.com/</loc>
    <priority>1.0</priority>
  </url>
  <url>
    <loc>https://jurnal.com/articles/judul-artikel</loc>
    <priority>0.8</priority>
  </url>
</urlset>
```

**Package:**
```bash
composer require spatie/laravel-sitemap
```

---

### 2.7 ADVANCED USER PROFILE ⭐⭐⭐
**Kenapa penting:** User bisa manage profil lengkap

**Fitur:**
- 📸 Profile photo upload
- 🏢 Affiliation (Universitas/Instansi)
- 🎓 Academic degree (S1, S2, S3, Prof)
- 📧 Public email
- 🔗 ORCID iD integration
- 🌐 Website/Blog URL
- 📝 Bio (short description)
- 📊 Public profile page (author page)

**Database Migration:**
```sql
ALTER TABLE users ADD COLUMN photo VARCHAR(255);
ALTER TABLE users ADD COLUMN affiliation VARCHAR(255);
ALTER TABLE users ADD COLUMN degree VARCHAR(50);
ALTER TABLE users ADD COLUMN orcid VARCHAR(50);
ALTER TABLE users ADD COLUMN website VARCHAR(255);
ALTER TABLE users ADD COLUMN bio TEXT;
```

**Public Author Page:**
```
URL: /authors/john-doe
Display: Photo, Name, Affiliation, Bio, Published Articles
```

---

## 📊 TAHAP 2 SUMMARY

| No | Feature | Priority | Difficulty | Estimasi |
|----|---------|----------|------------|----------|
| 2.1 | DOI Generator | ⭐⭐⭐⭐⭐ | Medium | 1 hari |
| 2.2 | Citation Formats | ⭐⭐⭐⭐⭐ | Easy | 0.5 hari |
| 2.3 | Export Reports | ⭐⭐⭐⭐ | Medium | 1.5 hari |
| 2.4 | Article Versioning | ⭐⭐⭐ | Hard | 1.5 hari |
| 2.5 | Peer Review System | ⭐⭐⭐⭐ | Hard | 2 hari |
| 2.6 | SEO Optimization | ⭐⭐⭐⭐ | Easy | 0.5 hari |
| 2.7 | User Profile Advanced | ⭐⭐⭐ | Easy | 1 hari |

**Total Estimasi:** 8 hari (tanpa error)

**Impact:** ⭐⭐⭐⭐⭐ (Menjadikan jurnal sangat profesional)

---

## 🚀 TAHAP 3: ADVANCED FEATURES & OPTIMIZATION (Priority Low-Medium)
**Target:** Fitur advanced dan optimasi performa
**Estimasi:** 5-7 hari
**Difficulty:** Hard

### 3.1 MULTI-LANGUAGE SUPPORT ⭐⭐⭐
**Kenapa penting:** Jurnal bisa dibaca internasional

**Fitur:**
- 🌍 Bahasa: Indonesia (default) + English
- 🔄 Language switcher di navbar
- 🗂️ Translate: UI, buttons, labels, messages
- 📝 Article: Title & Abstract dalam 2 bahasa (optional)

**Tech Stack:**
- Laravel Localization
- Language files: `resources/lang/en/` & `resources/lang/id/`

**Example:**
```php
// resources/lang/en/messages.php
return [
    'welcome' => 'Welcome',
    'articles' => 'Articles',
    'login' => 'Login',
];

// resources/lang/id/messages.php
return [
    'welcome' => 'Selamat Datang',
    'articles' => 'Artikel',
    'login' => 'Masuk',
];

// Blade
{{ __('messages.welcome') }}
```

---

### 3.2 FULL-TEXT SEARCH (ElasticSearch / Algolia) ⭐⭐⭐⭐
**Kenapa penting:** Search super cepat dengan relevance ranking

**Current:** MySQL LIKE query (slow untuk banyak data)

**Upgrade:**
- ⚡ Full-text search dengan ElasticSearch
- 🔍 Search dalam PDF content (OCR optional)
- 📊 Relevance ranking
- 🎯 Typo tolerance
- 💡 Search suggestions

**Tech Stack:**
- Laravel Scout + ElasticSearch
- atau Algolia (cloud-based, easier)

**Installation:**
```bash
composer require laravel/scout
composer require algolia/algoliasearch-client-php
```

**Alternative (Simpler):**
- MySQL Full-Text Search (built-in)
- TNTSearch (pure PHP, no external service)

---

### 3.3 ARTICLE COMMENTING SYSTEM ⭐⭐⭐
**Kenapa penting:** Discussion dan feedback dari pembaca

**Fitur:**
- 💬 Comment section di article detail
- 👤 Login required untuk comment
- ✍️ Reply to comment (threaded)
- ❤️ Like/Dislike comment
- 🚫 Admin moderation (approve/delete)
- 📧 Email notification untuk author

**Database Migration:**
```sql
CREATE TABLE comments (
    id BIGINT PRIMARY KEY,
    article_id BIGINT (foreign key),
    user_id BIGINT (foreign key),
    parent_id BIGINT (nullable, for replies),
    content TEXT,
    is_approved BOOLEAN DEFAULT false,
    likes_count INT DEFAULT 0,
    created_at TIMESTAMP
);
```

---

### 3.4 BOOKMARK / FAVORITE ARTICLES ⭐⭐⭐
**Kenapa penting:** User bisa save artikel favorit

**Fitur:**
- ⭐ Bookmark button di article card & detail
- 📚 My Bookmarks page
- 🗑️ Remove bookmark
- 📊 Count: berapa user bookmark artikel ini

**Database Migration:**
```sql
CREATE TABLE bookmarks (
    id BIGINT PRIMARY KEY,
    user_id BIGINT (foreign key),
    article_id BIGINT (foreign key),
    created_at TIMESTAMP,
    UNIQUE(user_id, article_id)
);

ALTER TABLE articles ADD COLUMN bookmarks_count INT DEFAULT 0;
```

---

### 3.5 RELATED ARTICLES (Recommendation) ⭐⭐⭐
**Kenapa penting:** Meningkatkan engagement

**Fitur:**
- 📌 "Related Articles" section di detail page
- 🎯 Algorithm: Same category + same keywords
- 📊 Display 4-6 related articles
- 🔄 Randomly shuffle untuk variety

**Implementation:**
```php
// Simple algorithm
$related = Article::where('category_id', $article->category_id)
    ->where('id', '!=', $article->id)
    ->where('status', 'published')
    ->inRandomOrder()
    ->limit(6)
    ->get();
```

**Advanced:**
- TF-IDF similarity (keywords matching)
- Collaborative filtering (user behavior)

---

### 3.6 ACTIVITY LOG (Admin) ⭐⭐⭐
**Kenapa penting:** Audit trail untuk keamanan

**Fitur:**
- 📝 Log semua actions: Create, Update, Delete
- 👤 Who did what when
- 🔍 Searchable log
- 📅 Filter by date range
- 📊 Export log to Excel

**Package:**
```bash
composer require spatie/laravel-activitylog
```

**Example:**
```
2026-11-03 10:30 | Admin (admin@jurnal.com) | Created article: "Judul Artikel"
2026-11-03 11:15 | Admin (admin@jurnal.com) | Approved submission ID: 5
2026-11-03 14:20 | User (user@jurnal.com) | Updated profile
```

---

### 3.7 PERFORMANCE OPTIMIZATION ⭐⭐⭐⭐
**Kenapa penting:** Website loading cepat

**Optimizations:**

**3.7.1 Database Optimization**
- ✅ Add indexes pada foreign keys
- ✅ Eager loading (N+1 query problem)
- ✅ Database query caching

**3.7.2 Image Optimization**
- ✅ Image compression (TinyPNG API)
- ✅ Lazy loading images
- ✅ WebP format support
- ✅ Thumbnail generation

**3.7.3 Caching Strategy**
- ✅ Cache homepage articles (5 minutes)
- ✅ Cache categories (1 hour)
- ✅ Cache statistics (30 minutes)
- ✅ Redis untuk session & cache (production)

**3.7.4 Asset Optimization**
- ✅ Minify CSS & JS
- ✅ Combine files (Laravel Mix / Vite)
- ✅ CDN untuk libraries (Bootstrap, Chart.js)

**3.7.5 LazyLoading**
- ✅ Pagination: 10 items per page
- ✅ Infinite scroll (optional)
- ✅ Image lazy loading

**Tools:**
- Laravel Debugbar (development)
- Google PageSpeed Insights
- GTmetrix

**Target:**
- Homepage: < 2 seconds
- Article detail: < 1.5 seconds
- Search results: < 1 second

---

### 3.8 API ENDPOINT (Optional) ⭐⭐
**Kenapa penting:** Integrasi dengan sistem lain

**Fitur:**
- 🔌 RESTful API untuk articles
- 🔑 API authentication (Bearer token)
- 📖 API documentation (Swagger)
- 📊 Rate limiting (60 requests/minute)

**Endpoints:**
```
GET /api/articles - List all published articles
GET /api/articles/{id} - Get article detail
GET /api/categories - List all categories
GET /api/search?q=keyword - Search articles
```

**Tech Stack:**
- Laravel Sanctum (API tokens)
- Swagger / Postman documentation

---

### 3.9 ADVANCED ADMIN DASHBOARD ⭐⭐⭐
**Kenapa penting:** Admin insights yang powerful

**Fitur:**
- 📊 Real-time statistics
- 📈 Advanced analytics dashboard
- 🗓️ Calendar view untuk submissions
- 📧 Bulk email to users
- 🚫 User management (ban/unban)
- ⚙️ System settings page

**Widgets:**
- Total articles, users, submissions
- Growth rate (this month vs last month)
- Most active users
- Most popular categories
- Recent activities timeline

---

### 3.10 DARK MODE ⭐⭐
**Kenapa penting:** Eye comfort untuk night reading

**Fitur:**
- 🌙 Dark mode toggle di navbar
- 💾 Remember preference (localStorage)
- 🎨 Dark theme untuk semua pages
- 📄 Article reading mode (dark background, light text)

**Implementation:**
```css
[data-theme="dark"] {
    --bg-color: #1a1a1a;
    --text-color: #ffffff;
    --card-bg: #2d2d2d;
}

[data-theme="light"] {
    --bg-color: #ffffff;
    --text-color: #333333;
    --card-bg: #f8f9fa;
}
```

---

## 📊 TAHAP 3 SUMMARY

| No | Feature | Priority | Difficulty | Estimasi |
|----|---------|----------|------------|----------|
| 3.1 | Multi-Language | ⭐⭐⭐ | Medium | 1.5 hari |
| 3.2 | Full-Text Search | ⭐⭐⭐⭐ | Hard | 2 hari |
| 3.3 | Commenting System | ⭐⭐⭐ | Medium | 1.5 hari |
| 3.4 | Bookmark System | ⭐⭐⭐ | Easy | 0.5 hari |
| 3.5 | Related Articles | ⭐⭐⭐ | Easy | 0.5 hari |
| 3.6 | Activity Log | ⭐⭐⭐ | Easy | 0.5 hari |
| 3.7 | Performance Optimization | ⭐⭐⭐⭐ | Medium | 2 hari |
| 3.8 | API Endpoint | ⭐⭐ | Medium | 1 hari |
| 3.9 | Advanced Dashboard | ⭐⭐⭐ | Medium | 1.5 hari |
| 3.10 | Dark Mode | ⭐⭐ | Easy | 0.5 hari |

**Total Estimasi:** 11.5 hari (tanpa error)

**Impact:** ⭐⭐⭐⭐ (Menjadikan jurnal sangat advanced & modern)

---

## 📋 REKAPITULASI 3 TAHAP

### 📊 TIMELINE & PRIORITY

| Tahap | Focus | Priority | Estimasi | Impact |
|-------|-------|----------|----------|--------|
| **TAHAP 1** | Fitur Dasar & UX | ⭐⭐⭐⭐⭐ HIGH | 5 hari | ⭐⭐⭐⭐⭐ |
| **TAHAP 2** | Profesionalisme | ⭐⭐⭐⭐ MEDIUM | 8 hari | ⭐⭐⭐⭐⭐ |
| **TAHAP 3** | Advanced & Optimization | ⭐⭐⭐ LOW-MEDIUM | 11.5 hari | ⭐⭐⭐⭐ |

**Total:** 24.5 hari (realistic: 30-35 hari dengan testing)

---

## 🎯 REKOMENDASI EKSEKUSI

### Skenario 1: CEPAT (Minimum Viable Upgrade)
**Target:** Meningkatkan profesionalisme dengan effort minimal

**Pilih dari Tahap 1:**
- ✅ Email Notifications (1.1)
- ✅ Article Statistics (1.2)
- ✅ Rich Text Editor (1.3)
- ✅ Dashboard Charts (1.6)

**Pilih dari Tahap 2:**
- ✅ DOI Generator (2.1)
- ✅ Citation Formats (2.2)
- ✅ SEO Optimization (2.6)

**Total:** 4 hari
**Impact:** Website sudah terlihat sangat profesional

---

### Skenario 2: BALANCED (Recommended)
**Target:** Balance antara fitur & waktu

**Kerjakan Tahap 1 SEMUA** (5 hari)
**Tambah dari Tahap 2:**
- ✅ DOI Generator (2.1)
- ✅ Citation Formats (2.2)
- ✅ Export Reports (2.3)
- ✅ SEO Optimization (2.6)

**Total:** 9 hari
**Impact:** Website sangat lengkap & profesional

---

### Skenario 3: COMPREHENSIVE (Full Upgrade)
**Target:** Website jurnal world-class

**Kerjakan:**
- ✅ Tahap 1 SEMUA
- ✅ Tahap 2 SEMUA
- ✅ Tahap 3 (pilih yang paling penting)

**Total:** 20-25 hari
**Impact:** Website jurnal setara jurnal internasional

---

## 💡 TIPS EKSEKUSI

### 1. **Prioritas User Impact**
Fitur yang langsung terasa user:
- Email notifications
- Statistics & charts
- Rich text editor
- Article preview

### 2. **Quick Wins First**
Fitur mudah tapi impactful:
- Article statistics (0.5 hari, impact besar)
- Rich text editor (0.5 hari, UX meningkat)
- Citation formats (0.5 hari, sangat profesional)

### 3. **Test Setiap Tahap**
Jangan langsung lompat ke tahap 2 sebelum tahap 1 selesai dan tested.

### 4. **Backup Database**
Sebelum mulai setiap tahap, backup database:
```bash
php artisan db:backup
# atau
mysqldump -u root DB_Eptik > backup_2026-11-03.sql
```

### 5. **Git Branching Strategy**
```bash
git checkout -b feature/email-notifications
git checkout -b feature/doi-generator
git checkout -b feature/charts-dashboard
```

Merge ke main setelah tested & working.

---

## 🚀 NEXT STEPS

### Jika ingin mulai, pilih salah satu:

**Option A: Mulai Tahap 1 Lengkap**
"Saya mau kerjakan TAHAP 1 lengkap (7 fitur)"

**Option B: Pilih Fitur Specific**
"Saya mau mulai dari [Email Notifications] dulu"

**Option C: Skenario Cepat**
"Saya mau Skenario 1 (4 hari, quick wins)"

**Option D: Custom**
"Saya mau pilih sendiri: [1.1, 1.2, 2.1, 2.2]"

---

## 📌 CATATAN PENTING

1. **Database Migration:** Selalu bikin backup sebelum migrate
2. **Testing:** Test di local dulu, baru production
3. **Email Config:** Perlu Gmail App Password atau SMTP lain
4. **Performance:** Monitor dengan Laravel Debugbar
5. **Security:** Tetap jaga CSRF, XSS, SQL injection protection
6. **Code Quality:** Follow Laravel best practices
7. **Documentation:** Update README.md setiap fitur baru

---

**STATUS:** ✅ RENCANA READY
**NEXT:** Pilih tahap atau skenario untuk mulai implementasi!

Mau mulai dari mana? 🚀
