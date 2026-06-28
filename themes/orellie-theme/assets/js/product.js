/**
 * Orellie — Product page: gallery ↔ variant selector sync
 *
 * When a gallery thumbnail is clicked:
 *   1. If the image belongs to a variant, update the dropdown to match.
 *   2. Show the variant name as a floating label over the gallery.
 *
 * When the dropdown changes to a found variation, show the label too.
 */
(function ($) {
  'use strict';

  $(document).ready(function () {
    var $form = $('form.variations_form');
    if (!$form.length) return;

    var variations = $form.data('product_variations');
    if (!variations || !variations.length) return;

    // Strip WooCommerce image size suffix: "-300x300.jpg" → ".jpg"
    function stripSize(url) {
      return url ? url.replace(/-\d+x\d+(\.[a-z]+)(\?.*)?$/i, '$1$2') : '';
    }

    // Build base-URL → variation map from embedded variation data
    var imageMap = {};
    variations.forEach(function (v) {
      if (v.image && v.image.full_src) {
        imageMap[stripSize(v.image.full_src)] = v;
      }
    });

    // Inject overlay into the main image wrapper (above thumbnails)
    var $wrapper = $('.woocommerce-product-gallery__wrapper');
    if (!$wrapper.length) $wrapper = $('.woocommerce-product-gallery');
    var $label = $('<div class="orellie-variant-label" aria-live="polite"></div>');
    $wrapper.append($label);

    function showLabel(text) {
      if (text) {
        $label.text(text).addClass('is-visible');
      } else {
        $label.removeClass('is-visible');
      }
    }

    // Get human-readable name from option text (handles PA slugs → labels)
    function getDisplayName(v) {
      if (!v || !v.attributes) return '';
      var parts = [];
      $.each(v.attributes, function (name, value) {
        if (value) {
          var optText = $form.find('select[name="' + name + '"] option[value="' + value + '"]').text().trim();
          parts.push(optText || value);
        }
      });
      return parts.join(' · ');
    }

    // Thumbnail click → sync dropdown + show label
    $(document).on('click', '.flex-control-thumbs li img', function () {
      var base = stripSize($(this).attr('src'));
      var v = imageMap[base];
      if (v) {
        $.each(v.attributes, function (name, value) {
          if (value) {
            $form.find('select[name="' + name + '"]').val(value).trigger('change');
          }
        });
        showLabel(getDisplayName(v));
      } else {
        showLabel('');
      }
    });

    // Dropdown fully matched a variation → show label
    $form.on('found_variation', function (e, v) {
      showLabel(getDisplayName(v));
    });

    // Dropdown reset / no match → hide label
    $form.on('reset_data', function () {
      showLabel('');
    });
  });

}(jQuery));
