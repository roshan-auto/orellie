# Orellie WordPress Theme

A premium, handcrafted WordPress + WooCommerce theme for the **Orellie** luxury earrings brand.

## Features

- **Custom landing page** matching the original Next.js design
- **Full WooCommerce integration** — shop, cart, checkout, product pages all styled
- **Responsive** — mobile-first design with hamburger menu
- **Orellie pink (#fb6593)** brand identity throughout
- **Playfair Display + Inter** font pairing
- **AJAX cart count** in navbar
- **Intersection Observer** fade-in animations
- **Fallback product grid** when no WooCommerce products exist yet

## Installation

1. Zip the `orellie-theme` folder
2. Go to WordPress Admin → Appearance → Themes → Add New → Upload Theme
3. Upload the zip and activate
4. Install & activate **WooCommerce** plugin
5. Go to Settings → Reading → set "Your homepage displays" to **A static page** → select a page, OR leave on default (the theme uses `front-page.php`)
6. Install & activate **WooCommerce Stripe Gateway** plugin for payments

## Required Plugins

| Plugin | Purpose |
|---|---|
| WooCommerce | E-commerce (shop, cart, checkout, orders) |
| WooCommerce Stripe Gateway | Stripe payment processing |

## Theme Structure

```
orellie-theme/
├── style.css              # Main stylesheet + design system
├── functions.php          # Theme setup, WooCommerce support
├── header.php             # Sticky navbar with cart icon
├── footer.php             # Branded footer with social links
├── front-page.php         # Landing page (hero + features + product grid)
├── woocommerce.php        # Shop page wrapper with hero banner
├── page.php               # Generic page template
├── index.php              # Fallback template
├── screenshot.png         # Theme preview (1200×900)
└── assets/
    ├── images/            # Theme-specific images.
    │   ├── signature/     # Contains 9 curated product model images for the homepage grid.
    │   ├── hero-model.png
    │   ├── scroll-model.png
    │   ├── product1.png
    │   └── product2.png
    └── js/
        └── main.js        # Mobile menu, scroll effects, animations
```

## Deploying Updates to Hostinger (Live Site)

`orellie.nz` runs this WordPress theme on **Hostinger** — not on Vercel. The Next.js app (`apps/orellie/src/`) is a mirrored frontend on Vercel that is **not the live site**.

After committing changes to the theme files on main, deploy from the repo root:

```powershell
.\apps\orellie\orsite.ps1 deploy "what changed" --expect "/path=text the page must show"
```

This pushes website-factory main and runs `orsite.py deploy` on Contabo (the Orellie bot's release script): lint, fast-forward push to `roshan-auto/orellie`, Hostinger pull, live smoke test, automatic rollback on failure. Never force-push `roshan-auto/orellie`. Details: [docs/wordpress-hostinger.md](../../../../../docs/wordpress-hostinger.md).

**Important:** Always update BOTH the WordPress theme files here AND the mirrored Next.js components in `apps/orellie/src/` so they stay in sync.

## Customisation

All brand colours and design tokens are in CSS custom properties at the top of `style.css`. Change `--orellie-pink` to rebrand the entire theme.
