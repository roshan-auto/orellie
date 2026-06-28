<?php
/**
 * Orellie Theme Custom Metadata
 * Handles signature grid image mapping with visual previews
 */

function orellie_add_signature_meta_box() {
    add_meta_box(
        'orellie_signature_meta',
        'Signature Grid Settings',
        'orellie_signature_meta_html',
        'product',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'orellie_add_signature_meta_box');

function orellie_signature_meta_html($post) {
    $raw   = get_post_meta($post->ID, '_orellie_signature_image', true);
    $exists = metadata_exists('post', $post->ID, '_orellie_signature_image');
    // New products (no meta saved yet) default to "unassigned"
    $value = $exists ? $raw : 'unassigned';

    $grid_images = [
        'signature/Earrings_with_matching_202604131110.jpeg',
        'signature/Earrings_with_matching_202604131110 (1).jpeg',
        'signature/Place_earring_onto_202604131109.jpeg',
        'signature/Earring_height_40mm_202604131110.jpeg',
        'signature/Earring_height_31_202604131110.jpeg',
        'signature/Stud_earring_diameter_202604131110.jpeg',
        'signature/Stud_earrings_14mm_202604131110.jpeg',
        'signature/Model_wearing_earring_202604131109.jpeg',
        'signature/Woman_revealing_earring_202604131110.jpeg'
    ];
    ?>
    <style>
        .orellie-grid-selector {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            margin-top: 10px;
        }
        .orellie-grid-item {
            position: relative;
            cursor: pointer;
            border-radius: 4px;
            overflow: hidden;
            border: 2px solid transparent;
            transition: all 0.2s;
            aspect-ratio: 1;
        }
        .orellie-grid-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .orellie-grid-item span {
            position: absolute;
            bottom: 0;
            right: 0;
            background: rgba(0,0,0,0.6);
            color: white;
            font-size: 10px;
            padding: 2px 5px;
            font-weight: bold;
        }
        .orellie-grid-item input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }
        .orellie-grid-item:hover {
            border-color: #fb6593;
        }
        .orellie-grid-item.is-selected {
            border-color: #fb6593;
            box-shadow: 0 0 0 2px rgba(251, 101, 147, 0.3);
        }
    </style>

    <p>Select home page slot (1-9):</p>
    <div class="orellie-grid-selector">

        <!-- Unassigned: excluded from grid entirely (default for new products) -->
        <label class="orellie-grid-item <?php echo ($value === 'unassigned') ? 'is-selected' : ''; ?>" title="Not shown on home page">
            <div style="background: #f6f7f7; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 4px; font-size: 10px; text-align: center; color: #646970;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#646970" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                <span style="font-weight:600;">None</span>
            </div>
            <input type="radio" name="orellie_signature_image" value="unassigned" <?php checked($value, 'unassigned'); ?>>
        </label>

        <!-- Auto: fills any empty slot (ordered by newest first) -->
        <label class="orellie-grid-item <?php echo ($value === '') ? 'is-selected' : ''; ?>" title="Auto-fill an empty slot">
            <div style="background: #f0f0f1; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 4px; font-size: 10px; text-align: center; color: #646970;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#646970" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <span style="font-weight:600;">Auto</span>
            </div>
            <input type="radio" name="orellie_signature_image" value="" <?php checked($value, ''); ?>>
        </label>

        <?php foreach ($grid_images as $index => $img_path):
            $num = $index + 1;
            $is_selected = ($value == $num);
            ?>
            <label class="orellie-grid-item <?php echo $is_selected ? 'is-selected' : ''; ?>">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/' . $img_path); ?>">
                <span><?php echo $num; ?></span>
                <input type="radio" name="orellie_signature_image" value="<?php echo $num; ?>" <?php checked($value, $num); ?>>
            </label>
        <?php endforeach; ?>
    </div>

    <script>
        document.querySelectorAll('.orellie-grid-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.orellie-grid-item').forEach(i => i.classList.remove('is-selected'));
                this.classList.add('is-selected');
            });
        });
    </script>
    <?php
}

function orellie_save_signature_meta($post_id) {
    if (isset($_POST['orellie_signature_image'])) {
        update_post_meta($post_id, '_orellie_signature_image', sanitize_text_field($_POST['orellie_signature_image']));
    } elseif (get_post_type($post_id) === 'product' && !metadata_exists('post', $post_id, '_orellie_signature_image')) {
        // Brand-new product saved without the meta box (e.g. quick-save) — default to unassigned
        update_post_meta($post_id, '_orellie_signature_image', 'unassigned');
    }
}
add_action('save_post', 'orellie_save_signature_meta');
