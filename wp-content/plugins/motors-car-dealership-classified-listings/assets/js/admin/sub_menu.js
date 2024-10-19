"use strict";

(function ($) {
  $(document).ready(function () {
    var classes = ['post-type-listings', 'post-type-test_drive_request'];
    var $settings_parent = $('.mvl-settings-menu-title').closest('li');
    $settings_parent.nextAll('li').addClass('mvl-pro-addons-menu');
    $settings_parent.addClass('mvl-settings-menu');
    //$settings_parent.next('li').addClass('mvl-addons-page-menu');

    if ($('li.mvl-pro-addons-menu:last').find('span.mvl-unlock-pro-btn').length > 0) {
      $('li.mvl-pro-addons-menu:last').removeClass('mvl-addons-page-menu').addClass('upgrade');
    }

    if ($('body').is("." + classes.join(', .'))) {
      $('#adminmenu > li').removeClass('wp-has-current-submenu wp-menu-open').find('wp-sumenu').css({
        'margin-right': 0
      });
      $('#toplevel_page_mvl_plugin_settings').addClass('wp-has-current-submenu wp-menu-open').removeClass('wp-not-current-submenu');
      $('.toplevel_page_mvl_plugin_settings').addClass('wp-has-current-submenu').removeClass('wp-not-current-submenu');
    }


  });
})(jQuery);