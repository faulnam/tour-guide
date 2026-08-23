# Rencana Implementasi Website "Interior Design Company Profile"
### Clone UI dari the-metaphor.com — Laravel + MySQL + Tailwind CSS (Pure, Tanpa Vite/NPM Run Dev)

> Dokumen ini adalah blueprint teknis lengkap. Belum berisi kode aplikasi — tujuannya adalah peta jalan yang bisa langsung dieksekusi step-by-step untuk membangun website company profile interior design dengan UI identik dengan referensi, dan **semua konten bisa di-CRUD** lewat admin panel.

---

## 1. Ringkasan Proyek

| Item | Detail |
|---|---|
| Tipe website | Company profile interior design (portfolio, blog, career, contact) |
| Referensi UI | https://the-metaphor.com/ (WordPress + Elementor + Revolution Slider) |
| Backend | Laravel 11 (PHP 8.2+) |
| Database | MySQL 8 |
| CSS | Tailwind CSS **standalone CLI** (binary, tanpa Node/NPM, tanpa Vite, tanpa `npm run dev`) |
| JS | Vanilla JS + Alpine.js (via CDN, tanpa build step) untuk interaktivitas ringan (dropdown menu, slider, accordion) |
| Auth admin | Laravel bawaan (session-based), tanpa Breeze/Vite scaffolding — dibuat manual |
| Upload gambar | Laravel Storage (`public` disk + `php artisan storage:link`) |
| Target hosting | Bisa jalan di shared hosting cPanel biasa (karena tidak butuh Node.js sama sekali di server) |

**Prinsip utama "tanpa Vite":** semua file `resources/css/app.css` dikompilasi **sekali** memakai Tailwind CLI binary standalone (bukan lewat `npm install` + `npm run dev`). Hasil compile disimpan statis di `public/css/app.css` dan di-link biasa lewat `<link>` tag. Tidak ada dev server, tidak ada hot-reload, tidak ada `package.json` yang wajib di server produksi.

---

## 2. Hasil Riset Mendalam — Struktur & Fitur the-metaphor.com

### 2.1 Peta Navigasi (Header Menu)

```
Home
About Us
Clients
Services
 ├─ Interior Design
 │   ├─ Work Space
 │   ├─ Public Space
 │   ├─ Hospitality
 │   ├─ Show Unit and Residence
 │   ├─ Commercial & Retail
 │   └─ Restaurant & Bar
 ├─ Interior Styling
 └─ 3D Visualization
Awards & Publications
Contact Us
Career
Our Blog
```
→ Ini adalah **menu 2 level (dropdown)**. Struktur ini jadi dasar tabel `services` (self-referencing parent_id).

### 2.2 Breakdown Fitur per Halaman

**A. Home (`/`)**
1. Hero section: judul "We are an Award-Winning interior design firm" + deskripsi perusahaan
2. Statistik angka besar: Total Projects (3.000+), Years Working Experience (20+)
3. Slider/carousel proyek unggulan (gambar besar full-width, judul proyek, tombol "View Project →")
4. Statistik lanjutan: Media Published & Awards (17+), Total Countries Served (5)
5. Tombol "View Our Portfolio"
6. Section "Recent Projects" — grid 3×3 (9 project card): gambar, label kategori, judul
7. Tombol "Check Our Services"
8. Section "Latest Insights" — 3 kartu blog terbaru (gambar, judul, excerpt)
9. Section "Our Clients" — grid logo klien (puluhan logo)
10. CTA "Want to start a new project?" + tombol Contact Us
11. Footer global (lihat 2.4)

**B. About Us (`/about-us`)**
1. Hero sama seperti home (reusable component)
2. 5 progress bar skill/kompetensi (Interior Design, Furniture Design, 3D Visualization, Interior Styling, Interior Construction Management) — semua 100%
3. 5 icon-box layanan (judul + deskripsi singkat)
4. Section "Who We Are" (paragraf profil perusahaan) & "Our Mission" (paragraf misi) + daftar penghargaan media + daftar nama klien (long text)
5. 4 kartu proyek pilihan (highlight)
6. 4 statistik: Associate Partners, Number of Clients, Team Members, Days of Work

**C. Clients (`/clients`)**
- Grid logo semua klien (mirror dari section "Our Clients" di Home, versi full)

**D. Services (`/services` + sub-halaman)**
- Halaman index: daftar kategori layanan (Interior Design, Interior Styling, 3D Visualization) dengan deskripsi & gambar
- Halaman per sub-layanan (mis. `/services/interior-design/work-space`): deskripsi layanan + grid proyek yang termasuk kategori tsb (relasi ke tabel projects)

**E. Awards & Publications (`/awards-publications`)**
- List berpaginasi (terbukti ada page 2, 3 di referensi) berisi kartu: judul penghargaan/publikasi, gambar, link ke detail

**F. Contact Us (`/contact-us`)**
1. Alamat kantor Jakarta
2. Email (info@, hrd1@)
3. Telepon (2 nomor telp + 1 WhatsApp)
4. Social media links
5. Embed Google Maps
6. Form kontak: Name, Email, Company, Message → submit → tersimpan ke DB + (opsional) email notifikasi

**G. Career (`/career`)**
1. Company info ("Who We Are", "Our Mission" — reuse dari About)
2. Heading "Join The Crew"
3. Daftar lowongan kerja (accordion), tiap lowongan punya:
   - Judul posisi
   - Responsibilities (list)
   - Requirements (list)
   - Tombol "Apply Now" (mailto dengan subject otomatis)

**H. Our Blog (`/our-blog`)**
- Index artikel (grid card: gambar, judul, excerpt, tanggal)
- Halaman detail artikel (`/our-blog/{slug}`): judul, gambar cover, isi konten, kategori

**I. Portfolio Detail (`/portfolio/{slug}`)**
1. Judul proyek
2. 2 paragraf deskripsi
3. Info detail: Location, Client, Size (m²), Year, Services (kategori — link ke halaman service)
4. Galeri foto (banyak gambar, grid)
5. Navigasi Prev/Next ke proyek lain
6. Sidebar "About Us" ringkas + "Selected Awards"

**J. Portfolio by Category (`/portfolio-cat/{slug}`)**
- Grid semua proyek dalam kategori tsb (mis. `restaurant-bar`, `public-space`, `show-unit-and-residence`, `commercial-retail`, `hospitality`, `work-space`)

### 2.3 Footer Global (tampil di semua halaman)
- Logo
- Social icons: Instagram, Facebook, Pinterest, Youtube, (link ke blog)
- Form newsletter (input email + submit)
- Alamat kantor Jakarta + tombol "Get Directions"
- Kontak: 2 nomor telepon + 2 email
- Copyright text

### 2.4 Analisis Visual / UI (Design Cues dari Screenshot & Situs)
- **Palet warna:** dominan putih & hitam/near-black; foto interior sebagai sumber warna utama; abu-abu untuk body text; tombol solid hitam dengan teks putih uppercase huruf kecil dan tracking lebar.
- **Tipografi:** heading besar sans-serif tegas (bold), label kecil uppercase dengan letter-spacing lebar sebagai "eyebrow text", angka statistik besar & tebal.
- **Tombol (CTA):** persegi/rounded-none atau rounded-sm, background hitam solid, hover invert (putih bg + border hitam) atau opacity, ada varian outline putih di atas foto hero gelap.
- **Kartu proyek:** foto penuh (cover), overlay gradient gelap di bagian bawah, label kategori kecil di atas judul, judul putih di pojok bawah-kiri.
- **Grid:** 3 kolom di desktop, 1 kolom di mobile, gap konsisten tanpa border/shadow berlebihan (flat/minimalist).
- **Section spacing:** padding vertikal besar antar section (terasa "lega"/generous whitespace), garis pemisah tipis warna abu-abu muda antar blok statistik.
- **Header:** transparan di atas hero (logo putih), berubah solid putih + logo hitam saat scroll (sticky). Dropdown menu 2 level.
- **Footer:** background hitam pekat, teks putih/abu terang, grid 4 kolom.

### 2.5 Semua Entitas Konten yang Harus Bisa Di-CRUD
Ringkasan (detail skema di Bagian 4):
1. Portfolio / Proyek + galeri gambar
2. Kategori Layanan (Services, 2 level: parent & child)
3. Klien & logo
4. Awards & Publications
5. Lowongan Kerja (Career)
6. Artikel Blog + kategori blog
7. Hero slides (banner homepage/subpage)
8. Testimoni (opsional, penambahan value)
9. Pesan dari form Contact Us (read-only inbox, admin bisa hapus/tandai dibaca)
10. Subscriber Newsletter (list, export, hapus)
11. Site Settings (angka statistik, kontak, alamat, social links, embed maps)
12. Page Content Blocks (paragraf "Who We Are", "Our Mission", deskripsi hero, dll — teks statis yang tetap bisa diedit tanpa sentuh kode)
13. User admin (role: super admin / editor)

---

## 3. Setup Tailwind CSS Tanpa Vite / NPM Run Dev

### 3.1 Kenapa Standalone CLI (bukan CDN, bukan Laravel Vite plugin)
| Opsi | Butuh Node? | Cocok untuk |
|---|---|---|
| Tailwind Play CDN (`<script src="cdn.tailwindcss.com">`) | Tidak | Prototyping cepat, TAPI tidak di-purge (file besar, tidak untuk produksi) |
| **Tailwind Standalone CLI (binary)** ✅ | **Tidak** | Rekomendasi utama — compile sekali jadi file CSS statis kecil, tanpa Vite, tanpa `npm run dev` |
| Laravel Vite plugin | Ya, wajib | Ini yang ingin dihindari sesuai permintaan |

### 3.2 Langkah Instalasi Tailwind Standalone CLI

```bash
# 1. Download binary sesuai OS (contoh Linux 64-bit) — sekali saja, tidak perlu npm
curl -sLO https://github.com/tailwindlabs/tailwindcss/releases/latest/download/tailwindcss-linux-x64
chmod +x tailwindcss-linux-x64
mv tailwindcss-linux-x64 tailwindcss   # taruh di root project, folder ini di-.gitignore boleh atau commit

# 2. Buat file konfigurasi
./tailwindcss init
```

**`tailwind.config.js`**
```js
module.exports = {
  content: [
    "./resources/views/**/*.blade.php",
  ],
  theme: {
    extend: {
      colors: {
        primary: "#111111",
        accent: "#B08D57", // aksen emas lembut opsional, bisa disesuaikan
      },
      fontFamily: {
        sans: ["Poppins", "sans-serif"],
      },
      letterSpacing: {
        widest2: "0.25em",
      },
    },
  },
  plugins: [],
}
```

**`resources/css/app.css`**
```css
@tailwind base;
@tailwind components;
@tailwind utilities;

@layer components {
  .btn-dark   { @apply inline-block bg-black text-white text-xs uppercase tracking-widest2 px-8 py-4 hover:bg-white hover:text-black border border-black transition; }
  .btn-outline{ @apply inline-block border border-white text-white text-xs uppercase tracking-widest2 px-8 py-4 hover:bg-white hover:text-black transition; }
  .eyebrow    { @apply text-xs uppercase tracking-widest2 text-gray-500; }
  .stat-number{ @apply text-4xl md:text-5xl font-bold text-black; }
}
```

**Perintah build (dijalankan tiap ada perubahan class, cukup 1 command, bukan dev server):**
```bash
./tailwindcss -i ./resources/css/app.css -o ./public/css/app.css --minify
```
> Selama development lokal boleh pakai `--watch` (opsional, murni file-watcher bawaan Tailwind CLI, BUKAN Vite/npm run dev):
> `./tailwindcss -i ./resources/css/app.css -o ./public/css/app.css --watch`

**Pemakaian di layout Blade:**
```blade
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
```

Tidak ada `package.json`, `node_modules`, atau `vite.config.js` yang dibutuhkan di server produksi — cukup PHP + MySQL, sesuai permintaan hosting sederhana.

### 3.3 JS Ringan Tanpa Build Step
Gunakan **Alpine.js via CDN** untuk dropdown menu, mobile nav toggle, slider/carousel sederhana, dan accordion FAQ/Career:
```blade
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
```
Untuk slider hero (pengganti Revolution Slider), pakai **Swiper.js via CDN** (opsional) atau carousel custom Alpine — tanpa build step apapun.

---

## 4. Desain Database (MySQL)

### 4.1 Diagram Relasi (ringkas)
```
services (self-referencing parent_id)
   └─< projects (belongsTo service)
projects ──< project_images
projects ──< (many-to-many opsional) awards
blog_categories ──< blog_posts
job_vacancies ──< job_applications (opsional)
clients (independen)
hero_slides (independen, punya field "page" untuk tahu dipasang di halaman mana)
testimonials (independen)
contact_messages (independen)
newsletter_subscribers (independen)
site_settings (key-value)
page_contents (key-value / rich text per section)
users (admin, role enum)
```

### 4.2 Detail Tabel & Kolom

**`services`** (kategori layanan, 2 level)
| Kolom | Tipe |
|---|---|
| id | bigint PK |
| parent_id | bigint nullable, FK → services.id |
| title | varchar |
| slug | varchar unique |
| excerpt | text nullable |
| description | longtext nullable |
| icon | varchar nullable (nama icon/svg) |
| image | varchar nullable |
| order | int default 0 |
| is_active | boolean default true |
| timestamps | |

**`projects`** (portfolio)
| Kolom | Tipe |
|---|---|
| id | bigint PK |
| service_id | bigint FK → services.id |
| title | varchar |
| slug | varchar unique |
| client | varchar nullable |
| location | varchar nullable |
| size | varchar nullable (mis. "758 m2") |
| year | varchar nullable |
| description | longtext nullable |
| cover_image | varchar |
| is_featured | boolean default false (tampil di hero slider home) |
| is_recent | boolean default false (tampil di grid "Recent Projects") |
| order | int default 0 |
| status | enum('draft','published') |
| meta_title, meta_description | varchar/text nullable |
| timestamps | |

**`project_images`**
| Kolom | Tipe |
|---|---|
| id | bigint PK |
| project_id | bigint FK |
| image_path | varchar |
| order | int default 0 |
| timestamps | |

**`clients`**
| Kolom | Tipe |
|---|---|
| id | bigint PK |
| name | varchar |
| logo | varchar |
| website_url | varchar nullable |
| order | int default 0 |
| is_active | boolean default true |
| timestamps | |

**`awards`**
| Kolom | Tipe |
|---|---|
| id | bigint PK |
| title | varchar |
| slug | varchar unique |
| image | varchar nullable |
| description | longtext nullable |
| external_link | varchar nullable |
| published_date | date nullable |
| order | int default 0 |
| is_active | boolean default true |
| timestamps | |

**`job_vacancies`**
| Kolom | Tipe |
|---|---|
| id | bigint PK |
| title | varchar |
| slug | varchar unique |
| responsibilities | longtext (disimpan sebagai list, 1 baris/poin atau JSON) |
| requirements | longtext (idem) |
| email_subject | varchar nullable |
| is_active | boolean default true |
| posted_at | date nullable |
| timestamps | |

**`job_applications`** *(opsional — jika mailto ingin diganti form upload CV)*
| Kolom | Tipe |
|---|---|
| id | bigint PK |
| job_vacancy_id | bigint FK |
| name, email, phone | varchar |
| cv_path, portfolio_path | varchar nullable |
| message | text nullable |
| status | enum('new','reviewed','rejected','accepted') |
| timestamps | |

**`blog_categories`**
| id | title | slug | timestamps |

**`blog_posts`**
| Kolom | Tipe |
|---|---|
| id | bigint PK |
| blog_category_id | bigint FK nullable |
| title | varchar |
| slug | varchar unique |
| excerpt | text nullable |
| content | longtext |
| cover_image | varchar |
| author | varchar nullable |
| is_published | boolean default true |
| published_at | datetime nullable |
| meta_title, meta_description | varchar/text nullable |
| timestamps | |

**`hero_slides`**
| Kolom | Tipe |
|---|---|
| id | bigint PK |
| page | enum('home','about','services','career', dst) default 'home' |
| image | varchar |
| title | varchar nullable |
| subtitle | varchar nullable |
| button_text | varchar nullable |
| button_link | varchar nullable |
| order | int default 0 |
| is_active | boolean default true |
| timestamps | |

**`testimonials`** *(opsional, nilai tambah)*
| id | client_name | client_company | message | photo | rating(int) | is_active | timestamps |

**`contact_messages`**
| id | name | email | company | message | is_read(boolean) | created_at |

**`newsletter_subscribers`**
| id | email(unique) | is_active | subscribed_at |

**`site_settings`** (key-value, dipakai untuk angka statistik & info kontak yang tampil berulang di banyak halaman)
| key | contoh value |
|---|---|
| total_projects | "3000+" |
| years_experience | "20+" |
| media_awards_count | "17+" |
| countries_served | "5" |
| associate_partners | "5" |
| total_clients | "60+" |
| team_members_count | "60" |
| days_of_work | "9000+" |
| company_phone_1 / 2 | ... |
| company_whatsapp | ... |
| company_email_info / hr | ... |
| company_address | ... |
| social_instagram / facebook / pinterest / youtube | url |
| map_embed_url | url |

**`page_contents`** (paragraf teks statis per section, biar admin bisa edit copywriting tanpa sentuh kode)
| key | contoh |
|---|---|
| home_hero_title / home_hero_description | ... |
| about_who_we_are | paragraf |
| about_mission | paragraf |
| career_who_we_are | paragraf |
| career_mission | paragraf |
| contact_intro_text | ... |

**`users`** (admin) — pakai tabel bawaan Laravel + tambahan kolom `role enum('super_admin','editor')`

---

## 5. Routing Plan

### 5.1 Public Routes (`routes/web.php`)
```
GET  /                                     HomeController@index
GET  /about-us                             AboutController@index
GET  /clients                              ClientController@index
GET  /services                             ServiceController@index
GET  /services/{parent}                    ServiceController@show
GET  /services/{parent}/{child}            ServiceController@showChild
GET  /awards-publications                  AwardController@index
GET  /awards-publications/{slug}           AwardController@show
GET  /contact-us                           ContactController@index
POST /contact-us                           ContactController@store
GET  /career                               CareerController@index
POST /career/{vacancy}/apply               CareerController@apply     (opsional)
GET  /our-blog                             BlogController@index
GET  /our-blog/{slug}                      BlogController@show
GET  /portfolio/{slug}                     ProjectController@show
GET  /portfolio-cat/{slug}                 ProjectController@byCategory
POST /newsletter/subscribe                 NewsletterController@store
```

### 5.2 Admin Routes (prefix `/admin`, middleware `auth`, `role:admin`)
```
GET/POST /admin/login , POST /admin/logout           Admin\AuthController
GET      /admin                                       Admin\DashboardController@index

Resource: /admin/projects            (index, create, store, edit, update, destroy)
Resource: /admin/projects/{id}/images (galeri: upload, reorder, delete)
Resource: /admin/services
Resource: /admin/clients
Resource: /admin/awards
Resource: /admin/job-vacancies
Resource: /admin/job-vacancies/{id}/applications (jika dipakai)
Resource: /admin/blog-categories
Resource: /admin/blog-posts
Resource: /admin/hero-slides
Resource: /admin/testimonials
GET/PUT  /admin/settings                (form 1 halaman, semua key site_settings)
GET/PUT  /admin/page-contents           (form 1 halaman, semua key page_contents)
GET      /admin/messages                (inbox contact form)
PATCH    /admin/messages/{id}/read
DELETE   /admin/messages/{id}
GET      /admin/subscribers
GET      /admin/subscribers/export
DELETE   /admin/subscribers/{id}
Resource: /admin/users                  (khusus super_admin)
```

---

## 6. Modul Admin Panel (Detail CRUD)

| Modul | Fitur List | Fitur Form |
|---|---|---|
| Dashboard | Ringkasan: total proyek, pesan belum dibaca, subscriber baru | — |
| Projects | Tabel + search + filter kategori + drag-reorder | Title, slug (auto), Service (select), Client, Location, Size, Year, Description (rich text/textarea), Cover image (upload+preview), Featured (checkbox), Recent (checkbox), Status, Galeri gambar (multi-upload, sortable) |
| Services | Tree list (parent → child) + drag-reorder | Title, slug, Parent (select nullable), Excerpt, Description, Icon, Image |
| Clients | Grid logo + drag-reorder | Name, Logo (upload), Website URL, Active toggle |
| Awards & Publications | Tabel + pagination | Title, slug, Image, Description, External link, Published date |
| Job Vacancies | Tabel aktif/nonaktif | Title, Responsibilities (repeater/textarea per baris), Requirements (repeater), Email subject, Posted date, Active toggle |
| Blog Posts | Tabel + filter kategori + status | Title, slug, Category, Excerpt, Content (rich text editor — TinyMCE/Quill via CDN, bukan npm), Cover image, Author, Publish toggle + tanggal |
| Blog Categories | Tabel sederhana | Title, slug |
| Hero Slides | List per halaman (home/about/dst) + reorder | Page, Image, Title, Subtitle, Button text, Button link, Active toggle |
| Testimonials | List | Client name, Company, Message, Photo, Rating |
| Site Settings | 1 form panjang (grouped by section) | Semua key statistik & kontak |
| Page Contents | 1 form panjang (grouped by halaman) | Semua paragraf statis (textarea/rich text) |
| Contact Messages | Tabel, badge belum dibaca | Read-only detail, tombol tandai dibaca / hapus |
| Newsletter Subscribers | Tabel + tombol export CSV | Read-only, hapus |
| Users | Tabel | Name, Email, Password, Role |

**Catatan editor teks kaya (rich text):** pakai **Quill.js via CDN** (`<script src="https://cdn.quilljs.com/1.3.7/quill.js">`) — tanpa NPM, cocok untuk field `description`/`content` supaya admin bisa format paragraf, bold, list, dsb.

---

## 7. Struktur Folder Laravel (Final)

```
app/
 ├─ Http/
 │   ├─ Controllers/
 │   │   ├─ HomeController.php
 │   │   ├─ AboutController.php
 │   │   ├─ ServiceController.php
 │   │   ├─ ClientController.php
 │   │   ├─ AwardController.php
 │   │   ├─ ContactController.php
 │   │   ├─ CareerController.php
 │   │   ├─ BlogController.php
 │   │   ├─ ProjectController.php
 │   │   ├─ NewsletterController.php
 │   │   └─ Admin/
 │   │       ├─ AuthController.php
 │   │       ├─ DashboardController.php
 │   │       ├─ ProjectController.php
 │   │       ├─ ProjectImageController.php
 │   │       ├─ ServiceController.php
 │   │       ├─ ClientController.php
 │   │       ├─ AwardController.php
 │   │       ├─ JobVacancyController.php
 │   │       ├─ BlogPostController.php
 │   │       ├─ BlogCategoryController.php
 │   │       ├─ HeroSlideController.php
 │   │       ├─ TestimonialController.php
 │   │       ├─ SettingController.php
 │   │       ├─ PageContentController.php
 │   │       ├─ MessageController.php
 │   │       ├─ SubscriberController.php
 │   │       └─ UserController.php
 │   ├─ Middleware/AdminOnly.php
 │   └─ Requests/  (Form Request per modul untuk validasi)
 └─ Models/
     ├─ Service.php  ├─ Project.php  ├─ ProjectImage.php
     ├─ Client.php   ├─ Award.php    ├─ JobVacancy.php
     ├─ JobApplication.php ├─ BlogPost.php ├─ BlogCategory.php
     ├─ HeroSlide.php ├─ Testimonial.php ├─ ContactMessage.php
     ├─ NewsletterSubscriber.php ├─ SiteSetting.php ├─ PageContent.php
     └─ User.php

resources/
 ├─ css/app.css                (source Tailwind)
 ├─ views/
 │   ├─ layouts/
 │   │   ├─ app.blade.php       (layout publik)
 │   │   └─ admin.blade.php     (layout admin: sidebar+topbar)
 │   ├─ partials/
 │   │   ├─ header.blade.php
 │   │   ├─ footer.blade.php
 │   │   ├─ hero-slider.blade.php
 │   │   ├─ project-card.blade.php
 │   │   ├─ stat-block.blade.php
 │   │   ├─ cta-section.blade.php
 │   │   └─ newsletter-form.blade.php
 │   ├─ home/index.blade.php
 │   ├─ about/index.blade.php
 │   ├─ clients/index.blade.php
 │   ├─ services/index.blade.php
 │   ├─ services/show.blade.php
 │   ├─ awards/index.blade.php
 │   ├─ awards/show.blade.php
 │   ├─ contact/index.blade.php
 │   ├─ career/index.blade.php
 │   ├─ blog/index.blade.php
 │   ├─ blog/show.blade.php
 │   ├─ portfolio/show.blade.php
 │   ├─ portfolio/category.blade.php
 │   └─ admin/
 │       ├─ dashboard.blade.php
 │       ├─ projects/{index,create,edit}.blade.php
 │       ├─ services/{index,create,edit}.blade.php
 │       ├─ clients/{index,create,edit}.blade.php
 │       ├─ awards/{index,create,edit}.blade.php
 │       ├─ job-vacancies/{index,create,edit}.blade.php
 │       ├─ blog-posts/{index,create,edit}.blade.php
 │       ├─ hero-slides/{index,create,edit}.blade.php
 │       ├─ testimonials/{index,create,edit}.blade.php
 │       ├─ settings/edit.blade.php
 │       ├─ page-contents/edit.blade.php
 │       ├─ messages/index.blade.php
 │       └─ subscribers/index.blade.php

public/
 ├─ css/app.css                 (hasil compile Tailwind)
 └─ storage -> ../storage/app/public   (symlink, dari `php artisan storage:link`)

database/
 ├─ migrations/ ...  (satu file per tabel di Bagian 4)
 └─ seeders/
     ├─ DatabaseSeeder.php
     ├─ ServiceSeeder.php      (isi data sesuai struktur menu referensi)
     ├─ SiteSettingSeeder.php  (isi default angka statistik)
     ├─ PageContentSeeder.php
     └─ AdminUserSeeder.php

routes/web.php
tailwind.config.js
tailwindcss                     (binary standalone)
```

---

## 8. Sistem Autentikasi Admin (Tanpa Breeze/Vite)

Karena Breeze default Laravel memakai Vite, kita buat **manual**:
1. Gunakan tabel `users` bawaan + kolom `role`.
2. Buat `Admin\AuthController` dengan method `showLogin`, `login`, `logout` — pakai `Auth::attempt()` standar Laravel (bagian dari `illuminate/auth`, tidak butuh Vite/JS build apapun).
3. Middleware `auth` + middleware custom `AdminOnly` untuk membatasi role.
4. View login: `resources/views/admin/auth/login.blade.php`, styled dengan Tailwind yang sudah dicompile.
5. Seeder `AdminUserSeeder` membuat 1 akun super_admin default saat instalasi.

---

## 9. Design System (Acuan UI)

| Token | Nilai |
|---|---|
| Font | Poppins / Inter (via Google Fonts `<link>`, bukan npm package) |
| Warna dasar | `#0A0A0A` (hitam teks/tombol), `#FFFFFF` (background), `#6B7280` (abu body text) |
| Warna aksen (opsional) | Emas lembut `#B08D57` untuk hover/detail kecil |
| Radius | `rounded-none` / `rounded-sm` (kesan tegas, minimalis) |
| Tombol utama | `bg-black text-white uppercase text-xs tracking-widest px-8 py-4 hover:bg-white hover:text-black border` |
| Tombol di atas foto (hero) | `border border-white text-white` versi outline |
| Section spacing | `py-20 md:py-28` antar section besar |
| Grid proyek | `grid grid-cols-1 md:grid-cols-3 gap-6` |
| Card proyek | foto full cover `aspect-[4/3]`, overlay gradient bawah `bg-gradient-to-t from-black/70`, label kategori `text-[11px] uppercase tracking-widest text-white/80`, judul `text-white font-medium` |
| Header | `fixed w-full z-50`, transparan di hero (`bg-transparent`), berubah `bg-white shadow-sm` saat `scrollY > 50` (pakai Alpine `x-data`/`@scroll.window`) |
| Footer | `bg-black text-gray-300`, grid 4 kolom `grid-cols-1 md:grid-cols-4 gap-10` |

---

## 10. Rencana Tahapan Pengerjaan (Milestones)

**Sprint 1 — Fondasi**
- Install Laravel, setup MySQL, setup Tailwind standalone CLI
- Buat semua migration + model + relasi
- Seeder data dummy (services sesuai menu referensi, 1 admin user)
- Layout dasar (header, footer, navigasi dropdown Alpine)

**Sprint 2 — Halaman Publik Statis-ish**
- Home, About Us, Clients, Contact Us (form + simpan ke DB), Career
- Komponen reusable: hero slider, stat block, CTA section, newsletter form

**Sprint 3 — Modul Portfolio & Services**
- Halaman Services index + detail per sub-service (filter proyek)
- Halaman Portfolio detail + galeri + prev/next
- Halaman Portfolio by category

**Sprint 4 — Blog & Awards**
- Blog index + detail + kategori
- Awards & Publications index (pagination) + detail

**Sprint 5 — Admin Panel Core**
- Auth admin manual
- CRUD Projects (+ galeri gambar), Services, Clients
- Dashboard ringkasan

**Sprint 6 — Admin Panel Lanjutan**
- CRUD Awards, Job Vacancies, Blog Posts/Categories, Hero Slides, Testimonials
- Form Settings & Page Contents (key-value editor)
- Inbox Messages & Subscribers (list, read, delete, export)

**Sprint 7 — Polish**
- Responsive check (mobile nav, grid stacking)
- SEO: meta title/description dinamis per halaman, sitemap.xml, robots.txt
- Optimasi gambar (resize saat upload via Intervention Image), lazy-load
- Compile Tailwind final dengan `--minify`, testing lintas browser

---

## 11. SEO, Performa & Keamanan (Checklist)

- [ ] Meta title & description dinamis per halaman (ambil dari field `meta_title`/`meta_description` atau fallback default)
- [ ] Slug otomatis dari title (pakai `Str::slug()`), validasi unik
- [ ] Sitemap.xml generate otomatis dari data projects/blog
- [ ] Gambar di-resize/compress saat upload (Intervention Image, tanpa perlu Node)
- [ ] Lazy-loading gambar (`loading="lazy"`)
- [ ] CSRF protection bawaan Laravel di semua form
- [ ] Rate limiting form contact & newsletter (`throttle` middleware) untuk cegah spam
- [ ] Validasi upload (mime type gambar, max size)
- [ ] Backup database berkala (opsional cron `mysqldump`)
- [ ] `.env` untuk kredensial DB & mail, tidak di-commit

---

## 12. Deployment (Cocok Shared Hosting/cPanel)

1. Upload seluruh project (tanpa `node_modules`, tidak dibutuhkan) via Git atau File Manager/FTP
2. `composer install --no-dev --optimize-autoloader`
3. Setup `.env` (DB, `APP_URL`, `APP_ENV=production`)
4. `php artisan migrate --seed`
5. `php artisan storage:link`
6. Compile Tailwind sekali di lokal, commit hasil `public/css/app.css` (server tidak perlu compile ulang, tidak perlu binary Tailwind di server)
7. `php artisan config:cache && php artisan route:cache && php artisan view:cache`
8. Arahkan document root ke folder `/public`

---

## 13. Checklist Fitur Lengkap (Ringkasan Final)

- [x] Header dropdown 2 level + sticky/transparent on scroll
- [x] Hero slider dinamis (CRUD hero_slides)
- [x] Statistik angka dinamis (CRUD site_settings)
- [x] Recent Projects grid dinamis (flag `is_recent`)
- [x] Latest Insights (blog) dinamis
- [x] Grid client logos dinamis
- [x] Halaman About Us dengan progress bar & mission text editable
- [x] Services 2 level dengan halaman filter proyek per sub-kategori
- [x] Portfolio detail + galeri + prev/next + kategori
- [x] Awards & Publications dengan pagination
- [x] Contact form tersimpan ke database + admin inbox
- [x] Career dengan daftar lowongan dinamis
- [x] Blog dengan kategori
- [x] Newsletter subscriber tersimpan + export
- [x] Admin panel full CRUD semua entitas di atas
- [x] Autentikasi admin dengan role
- [x] Tailwind CSS compile tanpa Vite/NPM run dev
- [x] Tanpa dependency Node.js di server produksi

---

## 14. Langkah Selanjutnya

Setelah plan ini disetujui, langkah build aktual disarankan urut sesuai **Bagian 10 (Sprint 1 → 7)**. Saya bisa langsung mulai membuatkan:
1. Struktur project Laravel + migration + model (Sprint 1), atau
2. Langsung tampilan Home page (Blade + Tailwind) sesuai UI referensi sebagai contoh visual dulu.

Beri tahu mana yang ingin dikerjakan lebih dulu.
