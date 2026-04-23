<?php
/**
 * Template Name: Contact Page
 */

get_header();

// Handle Form Submission
$message_sent = false;
if ( isset( $_POST['orellie_contact_submit'] ) ) {
    $name    = sanitize_text_field( $_POST['contact_name'] );
    $email   = sanitize_email( $_POST['contact_email'] );
    $subject = sanitize_text_field( $_POST['contact_subject'] );
    $message = sanitize_textarea_field( $_POST['contact_message'] );

    $to      = 'hello@orellie.nz';
    $headers = array( 'Content-Type: text/html; charset=UTF-8', 'From: Orellie Shop <hello@orellie.nz>', 'Reply-To: ' . $name . ' <' . $email . '>' );
    $body    = "<h3>New Contact Entry</h3>
                <p><strong>Name:</strong> $name</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Subject:</strong> $subject</p>
                <p><strong>Message:</strong><br>$message</p>";

    wp_mail( $to, 'New Contact: ' . $subject, $body, $headers );
    $message_sent = true;
}
?>

<div class="contact-page">
    <div class="container container--narrow">
        <div class="contact-header animate-fadeInUp">
            <div class="badge badge--pink">Get in touch</div>
            <h1>How can we help?</h1>
            <p>Whether you have a question about our jewellery, an existing order, or just want to say hi, we'd love to hear from you.</p>
        </div>

        <?php if ( $message_sent ) : ?>
            <div class="contact-success animate-fadeInUp">
                <div class="success-icon">✨</div>
                <h2>Thank you for your message!</h2>
                <p>We've received your inquiry and will get back to you at <strong><?php echo esc_html($email); ?></strong> as soon as possible.</p>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-outline">Back to Home</a>
            </div>
        <?php else : ?>
            <form action="<?php echo esc_url( get_permalink() ); ?>" method="POST" class="contact-form animate-fadeInUp animate-fadeInUp-delay-1">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="contact_name">Your Name</label>
                        <input type="text" name="contact_name" id="contact_name" placeholder="Name" required>
                    </div>
                    <div class="form-group">
                        <label for="contact_email">Email Address</label>
                        <input type="email" name="contact_email" id="contact_email" placeholder="email@example.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="contact_subject">Subject</label>
                    <input type="text" name="contact_subject" id="contact_subject" placeholder="What is this regarding?" required>
                </div>

                <div class="form-group">
                    <label for="contact_message">Message</label>
                    <textarea name="contact_message" id="contact_message" rows="6" placeholder="Tell us more..." required></textarea>
                </div>

                <div class="form-footer">
                    <button type="submit" name="orellie_contact_submit" class="btn btn-primary btn-lg">
                        Send Message
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                    </button>
                </div>
            </form>
        <?php endif; ?>

        <div class="contact-info animate-fadeInUp animate-fadeInUp-delay-2">
            <div class="info-item">
                <div class="info-icon">📍</div>
                <div>
                    <h4>Studio Location</h4>
                    <p>Handcrafted in Auckland, New Zealand</p>
                </div>
            </div>
            <div class="info-item">
                <div class="info-icon">✉️</div>
                <div>
                    <h4>Direct Email</h4>
                    <p><a href="mailto:hello@orellie.nz">hello@orellie.nz</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
