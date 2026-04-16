# Orellie Product Sideloading Workflow

This guide documents the automated workflow for importing products from the original `orellie.com` site (or any standard WooCommerce site) into our new WordPress environment.

## 🚀 The Process

When you provide a product URL, we follow these steps:

1.  **Extraction**: Use the **Browser Subagent** to navigate to the original URL and scrape the data (Name, Price, Description, Images, Categories, and Variations).
2.  **Staging**: Save the data to `resources/new-products.json`.
3.  **Import**: Run the `resources/import-json-products.php` script via WP-CLI inside the Docker container.

## 🛠️ The Import Script (`resources/import-json-products.php`)

This script is custom-designed for Orellie. It handles:
- **Simple Products**: Standard single-item earrings.
- **Variable Products**: Automatically detects attributes like "Size" or "Variety" and creates the corresponding WooCommerce variations.
- **Image Sideloading**: Automatically downloads images from the provided URLs and attaches them to the product in the Media Library.
- **Category Sync**: Automatically creates categories (like "Studs" or "Dangles") if they don't already exist.

## 📝 How to use it in the future

Simply provide me with the URLs. I will:
1.  Verify the data.
2.  Update the JSON and run the import script.
3.  Flush permalinks so the new product is visible at `/product/slug`.

## 📍 Current Status
The following products have been imported:
- [x] **Aqua Bloom**
- [x] **Ghostly Bloom**
- [x] **Glimmerloop** (Variations included)
- [x] **Nebula Glitter Drops** (Variations included)
- [x] **Halloween Pumpkin Earrings**
