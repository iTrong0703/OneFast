window.addEventListener('load', function() {
    setTimeout(function() {
        document.querySelectorAll('.elementor-editor-active a.view-type').forEach(function(item) {
            item.addEventListener('click', function(event) {
                event.stopPropagation();
            }, false);
        })
    }, 3000);
}, false);
