EZZO route fix

Upload the .htaccess file in this folder to the website root where index.php, about.php, blog.php, contact.php and quote.php exist.

This fixes clean URLs such as:
/about
/blog
/contact
/quote

The direct .php URLs will continue to work.

After upload, clear browser/cPanel/LiteSpeed/Cloudflare cache and test:
https://preview-ezzo.ezzogenics.com/about
https://preview-ezzo.ezzogenics.com/blog
https://preview-ezzo.ezzogenics.com/contact
https://preview-ezzo.ezzogenics.com/quote
