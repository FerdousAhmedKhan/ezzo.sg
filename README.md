# ezzo.sg v2 - cPanel PHP Website

Premium responsive website package for ezzo.sg, a Singapore doors, windows and skylights company.

## What is included in this update

- Sticky desktop/mobile header with hamburger navigation
- Navigation: Home, Doors, Windows, Skylights, Projects, About, Blog, Contact and prominent Get a Free Quote CTA
- Dedicated category pages for Doors, Windows and Skylights
- Complete all-products listing page with search/filter
- Dynamic product detail template with carousel, thumbnails, full-screen lightbox, specifications table, features, finishes/options, technical data, related products and quote form
- Projects listing with masonry-style grid and filters
- Dynamic project detail template with hero image, gallery/lightbox, scope, challenges, solutions, materials used, before/after and related projects
- Blog listing and dynamic blog post page
- Dedicated quote request page plus modal quote form
- Contact form and product inquiry forms with validation and CSRF protection
- SEO metadata, canonical URLs, Open Graph/Twitter cards and schema.org markup
- Core Web Vitals friendly static CSS/JS and WebP catalogue images
- Admin updates for products, projects, blog posts, testimonials, leads, quote requests and WhatsApp clicks
- Catalogue-derived sample content for 42 product models and 3 sample projects

## Product data source

The website includes sample product data based on the uploaded EZZODOORS catalogue. Catalogue pages were rendered into lightweight WebP files in:

```text
assets/images/catalog/
```

The full catalogue is included as:

```text
assets/downloads/product-brochure.pdf
```

## Main product groups included

### Doors

- Heavy Sliding Door: 127/190, TY120, TY150, 180 Arc
- Folding Door: 65, 68KSBG, 80KSBG
- Flat Door: 120 Outdoor Flat Door, 120 Aluminium Shutter Door, Outdoor Spring Door
- PT Doors: 65x33, 33x23
- Interior Doors: Interior Sliding, Pivot, French
- Room Door: Aluminium Wood Room Door / YD-M series

### Windows

- Casement Window: PRO110, E-120, S-90
- Sliding Window: 112, 123, 130 Side Press
- Folding Window: 65, 40, 55, 60
- American Window: 50, 70, 83
- Electric Lift Window: 125, 158

### Skylights

- SR-R30, SR-R90, SR-S110, SR-S85 Trackless, SR-S85 Railed, SR-R128, SR-R70, SR-R85, SR-R20, SR-S110S, SR-S180

## cPanel deployment

1. Upload all files from this folder to `public_html` or the target cPanel folder.
2. Create a MySQL database and database user in cPanel.
3. Import `database/schema.sql` for a fresh installation.
4. Edit `config.php` and update database details, `SITE_URL`, business email, phone, address and WhatsApp number.
5. Make sure the `uploads/` folder is writable. Usually `755` works; some hosts may need `775`.
6. Visit `/admin/login.php`.
7. Default admin login after importing schema:
   - Email: `admin@example.com`
   - Password: `Admin@123`
8. Change the default admin login after launch.

## Existing database upgrade

If the site already has the old database, run this file in phpMyAdmin first:

```text
database/update_schema_v2.sql
```

This adds the new product, project and blog fields used by the v2 admin panel.

## Admin panel

Admin can manage:

- Categories
- Products with model code, family/subcategory, hero image, gallery images, SEO title/meta description, specifications, finishes and technical data
- Projects with gallery, scope, challenges, solutions, materials, year, before/after and SEO fields
- Blog posts
- Testimonials
- Contact leads
- Quote requests
- WhatsApp clicks

## Notes

- The public site will show the built-in catalogue sample data even if the database has no product rows.
- Admin-created products and projects are merged with the built-in sample catalogue data.
- Replace sample project photos with real installation photography for stronger trust and conversions.
- Connect SMTP/PHPMailer later if cPanel `mail()` deliverability is weak.
- Submit `/sitemap.xml` to Google Search Console after updating `SITE_URL`.


## Clean URL update
Public navigation now uses extensionless URLs such as `/about`, `/blog`, `/contact`, and `/quote`. Product, project, and blog detail URLs use `/product/{slug}`, `/project/{slug}`, and `/blog/{slug}`. The quote modal has been removed; all quote CTAs open the dedicated quote request page.
