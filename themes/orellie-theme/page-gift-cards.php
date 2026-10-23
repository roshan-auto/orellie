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

            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
