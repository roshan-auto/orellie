<?php
/**
 * Template Name: Gift Cards Page
 */

get_header();
?>

<div class="gift-cards-page">
    <div class="container">
        <div class="gift-cards-hero animate-fadeInUp">
            <div class="badge badge--pink">Gifts</div>
            <h1>The Gift of Choice</h1>
            <p>Can't decide? Give them the opportunity to choose their own perfect piece of handcrafted radiance.</p>
        </div>

        <div class="gift-cards-grid">
            <div class="gift-card-display animate-fadeInUp animate-fadeInUp-delay-1">
                <div class="gift-card-preview">
                    <div class="card-logo">orellie</div>
                    <div class="card-amount">$100</div>
                    <div class="card-tag">Gift Certificate</div>
                </div>
            </div>

            <div class="gift-cards-content animate-fadeInUp animate-fadeInUp-delay-2">
                <h2>Orellie Digital Gift Cards</h2>
                <div class="feature-list">
                    <div class="feature-item">
                        <div class="feature-icon">✨</div>
                        <p>Delivered instantly to their inbox</p>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">💎</div>
                        <p>Redeemable on any item in our store</p>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">📦</div>
                        <p>No expiration date</p>
                    </div>
                </div>

                <div class="status-box">
                    <p><strong>Note:</strong> We are currently setting up our automated gift card system. To purchase a gift card today, please contact us at <a href="mailto:hello@orellie.nz">hello@orellie.nz</a> and we'll arrange a custom code for you manually.</p>
                    <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-primary">Contact Us to Order</a>
                </div>

                <div class="implementation-suggestions" style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--border);">
                    <h4 style="margin-bottom: 1rem; color: var(--foreground);">Pro Implementation Suggestions:</h4>
                    <p style="font-size: 0.9rem; color: var(--muted-foreground); margin-bottom: 1rem;">To implement fully automated gift cards that generate unique codes and allow checkout redemption, we recommend:</p>
                    <ul style="font-size: 0.9rem; color: var(--muted-foreground); space-y: 0.5rem; list-style-type: disc; padding-left: 1.5rem;">
                        <li><strong>WooCommerce Gift Cards (Official)</strong>: The most robust option for creating, selling, and managing gift cards with full balance tracking.</li>
                        <li><strong>YITH WooCommerce Gift Cards</strong>: A popular alternative with a great free version and a powerful premium version for custom card designs.</li>
                        <li><strong>PW WooCommerce Gift Cards</strong>: Extremely easy to set up and very reliable for digital delivery.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
