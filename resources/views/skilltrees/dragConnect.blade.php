<script type="text/javascript" src="/js/jqSimpleConnect.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function(event) {

        let controller = panzoom(document.querySelector('.skillzone'));

        controller.on('pan', function() {
            jqSimpleConnect.repaintAll();
        });

        controller.on('zoom', function(e) {
            jqSimpleConnect.repaintAll();
        });

        window.addEventListener("keydown", function(e) {
            if (e.altKey && controller.isPaused())
            {
                controller.resume();
            }
        });
        window.addEventListener("keyup", function(e) {
            controller.pause();
        });
        controller.pause();
    }, { passive: true });
</script>
