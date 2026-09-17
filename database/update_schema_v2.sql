ALTER TABLE products ADD COLUMN IF NOT EXISTS subcategory VARCHAR(140) NULL AFTER slug;
ALTER TABLE products ADD COLUMN IF NOT EXISTS model_code VARCHAR(90) NULL AFTER subcategory;
ALTER TABLE products ADD COLUMN IF NOT EXISTS finishes_options TEXT NULL AFTER benefits;
ALTER TABLE products ADD COLUMN IF NOT EXISTS technical_data TEXT NULL AFTER finishes_options;
ALTER TABLE products ADD COLUMN IF NOT EXISTS seo_title VARCHAR(255) NULL AFTER hero_image;
ALTER TABLE products ADD COLUMN IF NOT EXISTS meta_description TEXT NULL AFTER seo_title;
ALTER TABLE projects ADD COLUMN IF NOT EXISTS filters TEXT NULL AFTER project_type;
ALTER TABLE projects ADD COLUMN IF NOT EXISTS scope TEXT NULL AFTER description;
ALTER TABLE projects ADD COLUMN IF NOT EXISTS challenges TEXT NULL AFTER scope;
ALTER TABLE projects ADD COLUMN IF NOT EXISTS solutions TEXT NULL AFTER challenges;
ALTER TABLE projects ADD COLUMN IF NOT EXISTS materials_used TEXT NULL AFTER solutions;
ALTER TABLE projects ADD COLUMN IF NOT EXISTS project_year VARCHAR(20) NULL AFTER materials_used;
ALTER TABLE projects ADD COLUMN IF NOT EXISTS gallery_images TEXT NULL AFTER project_year;
ALTER TABLE projects ADD COLUMN IF NOT EXISTS seo_title VARCHAR(255) NULL AFTER main_image;
ALTER TABLE projects ADD COLUMN IF NOT EXISTS meta_description TEXT NULL AFTER seo_title;
CREATE TABLE IF NOT EXISTS blog_posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(220) NOT NULL,
  slug VARCHAR(240) NOT NULL UNIQUE,
  category VARCHAR(120),
  excerpt TEXT,
  content LONGTEXT,
  image TEXT,
  seo_title VARCHAR(255),
  meta_description TEXT,
  status VARCHAR(30) DEFAULT 'published',
  published_at DATE DEFAULT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
INSERT INTO categories(id,name,slug,sort_order) VALUES (1,'Doors','doors',1),(2,'Windows','windows',2),(3,'Skylights','skylights',3) ON DUPLICATE KEY UPDATE name=VALUES(name),slug=VALUES(slug),sort_order=VALUES(sort_order);
