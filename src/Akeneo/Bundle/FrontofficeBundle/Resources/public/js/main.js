$(function () {
    App.init($(this));
});

App = {
    init: function(scope) {
        $('.select2', scope).select2();
        $('.datetimepicker', scope).datetimepicker();
        $(".geolocate")
            .each(function() {initAutocomplete($(this));})
            .focus(function() {geolocate($(this));});
    }
};

var observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
        for (i = 0; i < mutation.addedNodes.length; i++) {
            $node = $(mutation.addedNodes[i]);
            App.init($node);

            if ($node.is('form')) {
                $node.submit(function(event) {
                    event.preventDefault();
                    $that = $(this);
                    $('button[type=submit]', $that).button('loading');

                    $.post($that.attr('action'), $that.serialize())
                        .done(function(data, textStatus, jqXHR) {
                            if (201 == jqXHR.status) {
                                window.scrollTo(0,0);
                                window.location.reload();
                            }

                            $that.replaceWith(data);
                            $('button[type=submit]', $that).button('reset');
                        });
                });
            }
        }
    });

    observer.disconnect();
});

var includes = document.getElementsByTagName('hx:include');
for (i = 0; i < includes.length; i++) {
    observer.observe(includes[i], {childList: true});
}
