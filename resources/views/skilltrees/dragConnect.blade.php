<script type="text/javascript" src="/js/jqSimpleConnect.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        let area = document.querySelector('.skillzone');
        let controller = panzoom(area, {
            beforeWheel: function(e) {
                jqSimpleConnect.repaintAll();
            }
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
    });
</script>