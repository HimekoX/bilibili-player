// initialize clipboard plugin
    if ($('.clipboard-icon').length) {
      var clipboard = new ClipboardJS('.clipboard-icon');

      // Enabling tooltip to all clipboard buttons
      $('.clipboard-icon').attr('data-toggle', 'tooltip').attr('title', 'Copy to clipboard');

      // initializing bootstrap tooltip
      $('[data-toggle="tooltip"]').tooltip();

      // initially hide btn-clipboard and show after copy
      clipboard.on('success', function(e) {
        e.trigger.classList.value = 'clipboard-icon clipboard-icon-current'
        $('.clipboard-icon-current').tooltip('hide');
        e.trigger.dataset.originalTitle = 'Copied';
        $('.clipboard-icon-current').tooltip('show');
        setTimeout(function(){
            $('.clipboard-icon-current').tooltip('hide');
            e.trigger.dataset.originalTitle = 'Copy to clipboard';
            e.trigger.classList.value = 'clipboard-icon'
        },1000);
        e.clearSelection();
      });
    }