/**
 * Orellie — Product page: gallery ↔ variant selector sync
 *
 * Handles three directions:
 *  1. Dropdown change  → animate gallery to matching slide + show label
 *  2. Thumbnail click  → update dropdown + show label
 *  3. Swipe (mobile)   → update dropdown + show label (via MutationObserver)
 */
(function ($) {
  'use strict';

  $(document).ready(function () {
    var $form = $('form.variations_form');
    if (!$form.length) return;

    var variations = $form.data('product_variations');
    if (!variations || !variations.length) return;

    // Strip WooCommerce size suffix: "-300x300.jpg" → ".jpg"
    function stripSize(url) {
      return url ? url.replace(/-\d+x\d+(\.[a-z]+)(\?.*)?$/i, '$1$2') : '';
    }

    // Map full_src AND src to each variation for maximum match coverage
    var imageMap = {};
    variations.forEach(function (v) {
      if (v.image) {
        if (v.image.full_src) imageMap[stripSize(v.image.full_src)] = v;
        if (v.image.src)      imageMap[stripSize(v.image.src)]      = v;
      }
    });

    // ── Overlay label ────────────────────────────────────────────────────
    var $gallery = $('.woocommerce-product-gallery');
    var $label   = $('<div class="orellie-variant-label" aria-live="polite"></div>');
    $gallery.append($label);

    // Position the label at the bottom of the main image (above thumbnails)
    function positionLabel() {
      var thumbsH = $gallery.find('.flex-control-thumbs').outerHeight(true) || 0;
      $label.css('bottom', thumbsH + 'px');
    }
    // Run immediately and again after WooCommerce gallery JS has had time to init
    positionLabel();
    setTimeout(positionLabel, 200);
    setTimeout(positionLabel, 800);
    $(window).on('resize', positionLabel);

    function showLabel(text) {
      if (text) {
        $label.text(text).addClass('is-visible');
      } else {
        $label.removeClass('is-visible');
      }
    }

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

    // ── Direction 1: Dropdown → Gallery ─────────────────────────────────
    // Guard to stop the gallery→dropdown observer from firing a loop
    var _syncingFromDropdown = false;

    $form.on('found_variation', function (e, v) {
      showLabel(getDisplayName(v));

      // Find which gallery slide matches this variation's image and jump to it
      if (v.image && v.image.full_src) {
        var targetBase = stripSize(v.image.full_src);
        var slideIndex = -1;
        $gallery.find('.flex-control-thumbs li img').each(function (i) {
          // data-large_image holds the full-size URL on WooCommerce thumbnails
          var large = stripSize($(this).data('large_image') || $(this).attr('src') || '');
          if (large === targetBase) {
            slideIndex = i;
            return false; // break
          }
        });
        if (slideIndex >= 0) {
          var slider = $gallery.data('flexslider');
          if (slider && typeof slider.flexAnimate === 'function') {
            _syncingFromDropdown = true;
            slider.flexAnimate(slideIndex);
            setTimeout(function () { _syncingFromDropdown = false; }, 400);
          }
        }
      }
    });

    $form.on('reset_data', function () {
      showLabel('');
    });

    // ── Directions 2 & 3: Gallery → Dropdown ────────────────────────────
    // Given a thumbnail <img>, resolve the variation and update the dropdown
    function syncDropdownFromThumb($thumbImg) {
      if (_syncingFromDropdown) return;
      var largeSrc = $thumbImg.data('large_image') || $thumbImg.attr('src') || '';
      var v = imageMap[stripSize(largeSrc)];
      if (v) {
        $.each(v.attributes, function (name, value) {
          if (value) {
            $form.find('select[name="' + name + '"]').val(value).trigger('change');
          }
        });
        // label is shown via the found_variation event triggered by .trigger('change')
      } else {
        showLabel('');
      }
    }

    // Direction 2: explicit thumbnail click (desktop + tablet)
    $gallery.on('click', '.flex-control-thumbs li img', function () {
      syncDropdownFromThumb($(this));
    });

    // Direction 3: any slide change including swipe (mobile) via MutationObserver
    var $wrapper    = $gallery.find('.woocommerce-product-gallery__wrapper');
    var _lastSlide  = -1;

    if ($wrapper.length && window.MutationObserver) {
      var mo = new MutationObserver(function () {
        // Flexslider marks the active slide with flex-active-slide
        var $activeSlide = $wrapper.find('.woocommerce-product-gallery__image.flex-active-slide');
        if (!$activeSlide.length) return;

        var slideIdx = $activeSlide.index();
        if (slideIdx === _lastSlide) return; // no change
        _lastSlide = slideIdx;

        var $thumb = $gallery.find('.flex-control-thumbs li').eq(slideIdx).find('img');
        if ($thumb.length) syncDropdownFromThumb($thumb);
      });

      mo.observe($wrapper[0], {
        subtree:         true,
        attributes:      true,
        attributeFilter: ['class']
      });
    }
  });

}(jQuery));
