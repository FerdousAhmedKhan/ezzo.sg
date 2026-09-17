CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role VARCHAR(40) DEFAULT 'admin',
  status VARCHAR(30) DEFAULT 'active',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  slug VARCHAR(140) NOT NULL UNIQUE,
  sort_order INT DEFAULT 0,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT NULL,
  name VARCHAR(190) NOT NULL,
  slug VARCHAR(220) NOT NULL UNIQUE,
  subcategory VARCHAR(140) NULL,
  model_code VARCHAR(90) NULL,
  short_description TEXT,
  description TEXT,
  features TEXT,
  specifications TEXT,
  materials TEXT,
  colors TEXT,
  benefits TEXT,
  finishes_options TEXT,
  technical_data TEXT,
  gallery_images TEXT,
  hero_image TEXT,
  seo_title VARCHAR(255),
  meta_description TEXT,
  featured TINYINT(1) DEFAULT 0,
  sort_order INT DEFAULT 0,
  status VARCHAR(30) DEFAULT 'published',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS projects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(190) NOT NULL,
  slug VARCHAR(220) NOT NULL UNIQUE,
  location VARCHAR(190),
  project_type VARCHAR(80),
  filters TEXT,
  product_type VARCHAR(190),
  description TEXT,
  scope TEXT,
  challenges TEXT,
  solutions TEXT,
  materials_used TEXT,
  project_year VARCHAR(20),
  gallery_images TEXT,
  before_images TEXT,
  after_images TEXT,
  main_image TEXT,
  seo_title VARCHAR(255),
  meta_description TEXT,
  featured TINYINT(1) DEFAULT 0,
  status VARCHAR(30) DEFAULT 'published',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

CREATE TABLE IF NOT EXISTS testimonials (
  id INT AUTO_INCREMENT PRIMARY KEY,
  client_name VARCHAR(140) NOT NULL,
  client_role VARCHAR(140),
  rating TINYINT DEFAULT 5,
  content TEXT NOT NULL,
  status VARCHAR(30) DEFAULT 'published',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS leads (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(140),
  phone VARCHAR(80),
  email VARCHAR(190),
  city VARCHAR(120),
  product_interest VARCHAR(190),
  message TEXT,
  source_page VARCHAR(190),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS quote_requests (
  id INT AUTO_INCREMENT PRIMARY KEY,
  project_type VARCHAR(120),
  product_category VARCHAR(220),
  city VARCHAR(120),
  timeline VARCHAR(120),
  project_details TEXT,
  name VARCHAR(140),
  phone VARCHAR(80),
  email VARCHAR(190),
  preferred_contact VARCHAR(190),
  message TEXT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS whatsapp_clicks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  message TEXT,
  source_page TEXT,
  ip_address VARCHAR(80),
  user_agent TEXT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO users(name,email,password_hash,role,status) VALUES
('Admin','admin@example.com','$2y$12$wdRi2/kixkSC6Ih1CPxC1OOuHPg40OVfBoRZ1U.wZAaYj4WkJ1WDW','admin','active')
ON DUPLICATE KEY UPDATE email=email;

INSERT INTO categories(id,name,slug,sort_order) VALUES
(1,'Doors','doors',1),(2,'Windows','windows',2),(3,'Skylights','skylights',3)
ON DUPLICATE KEY UPDATE name=VALUES(name), slug=VALUES(slug), sort_order=VALUES(sort_order);

INSERT INTO testimonials(client_name,client_role,rating,content,status) VALUES
('Sarah M.','Homeowner',5,'Beautiful finish, clean installation and very professional communication from first visit to handover.','published'),
('Daniel R.','Architect',5,'A reliable glazing partner for detailed residential work. The team understood the design intent perfectly.','published'),
('Amina K.','Business Owner',5,'Our office now feels brighter and more premium.','published');

INSERT INTO blog_posts(title,slug,category,excerpt,content,image,seo_title,meta_description,status,published_at) VALUES
('How to Choose Doors and Windows for Singapore Weather','choose-doors-windows-singapore-weather','Buying Guide','A practical guide to selecting aluminium doors and windows for heat, humidity, heavy rain and everyday comfort in Singapore.','Singapore homes need door and window systems that manage heat, sudden rainfall, humidity and daily use. Start with aluminium profiles, quality sealing, safe glass, suitable drainage details and hardware that matches the opening size.','assets/images/Ezzo-products-doors-windows.jpg','How to Choose Doors and Windows for Singapore Weather | ezzo.sg','A practical guide to selecting aluminium doors and windows for heat, humidity, heavy rain and everyday comfort in Singapore.','published','2026-06-22')
ON DUPLICATE KEY UPDATE title=VALUES(title);
