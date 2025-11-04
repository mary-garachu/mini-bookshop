#  Mini Bookstore

## Overview

**Mini Bookstore** is a WordPress project that brings together **custom post types**, **Advanced Custom Fields (ACF)**, and **WooCommerce** into a simple yet functional bookstore.  

The goal is to allow admins to manage books as custom posts, each linked to a WooCommerce product via a shared **ISBN (Book)** → **SKU (Product)** relationship.  
Visitors can view book details, add them to their cart, and complete checkout — all through WooCommerce.

---

## Features

###  Custom Post Type: Books
- A new **Book** post type is registered to manage your catalog.
- Each Book post includes:
  - Title & Featured Image
  - Author
  - ISBN
  - Price
  - Cover Image
  - Summary (via ACF)

###  WooCommerce Integration
- Each book is automatically linked to its matching WooCommerce product.
- ISBN (from ACF) is matched to Product SKU (from WooCommerce).
- The **Add to Cart** and **View Cart** buttons appear directly on the single book page.
- Checkout is handled via WooCommerce (with Stripe integration in test mode).

### ⚙️ Advanced Custom Fields (ACF)
ACF provides an easy way to manage book data fields:
- Author  
- ISBN  
- Price  
- Cover Image  
- Summary  

### Custom Child Theme
The **Mini Bookstore** child theme handles all front-end display:
- Clean, responsive layout for single book pages.
- Styled Add to Cart and View Cart buttons.
- Organized CSS, no inline styles.

---

### Activate required plugins

From your WordPress Dashboard, go to Plugins → Installed Plugins and make sure the following are active:

WooCommerce

Advanced Custom Fields

### Activate the Mini Bookstore Theme

Go to Appearance → Themes and activate the Mini Bookstore child theme.

### Create WooCommerce Products

Each product should:

Have an SKU that matches the ISBN of a book.

Include a price.

Example:

Product	SKU (ISBN)	Price
The WordPress Journey	9781111111111	2100

### Add Books

Go to Books → Add New and fill in the ACF fields:

Author

ISBN (must match the WooCommerce SKU)

Price

Cover Image

Summary

### Set up Cart and Checkout Pages

Go to WooCommerce → Settings → Advanced and make sure:

Cart page → /cart

Checkout page → /checkout

How the ISBN–SKU Mapping Works

Each book connects to its corresponding WooCommerce product through this logic:

$isbn = get_field('isbn');
$product_id = wc_get_product_id_by_sku($isbn);

if ($product_id) {
    echo do_shortcode('[add_to_cart id="' . $product_id . '"]');
}


This ensures the correct product is added to the cart when a user clicks Add to Cart on a Book page.

### Common Issues
| Issue               | Cause                                          | Fix                                              |
| ------------------- | ---------------------------------------------- | ------------------------------------------------ |
| Price appears twice | ACF price and WooCommerce price both displayed | Remove one (usually keep only WooCommerce price) |
| Stripe not working  | Missing `wp_footer()` or `wp_head()` hooks     | Add these to `header.php` and `footer.php`       |
| Buttons too close   | CSS margin missing                             | Add spacing in `.mb-buy-container`               |

### Git Setup

After cloning or initializing locally:

git init
git add .
git commit -m "Initial commit - Mini Bookstore project setup"
git branch -M main
git remote add origin https://github.com/yourusername/mini-bookstore.git
git push -u origin main

### Author

Built by Sonie
Focused on WordPress development, custom post types, and WooCommerce integration.

### License

This project is open for learning and development purposes.
You can reuse, modify, and extend it for your own educational or experimental work.