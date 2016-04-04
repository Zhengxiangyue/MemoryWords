<?php require_once("header.php"); ?>

<script>
    function socket(){
        var socket = new WebSocket(<?php echo base_url('word/pk')?>");
        socket.onopen = function () {
            alert("Socket has been opened!");
        }
        socket.onmessage = function (msg) {
            alert(msg); //Awesome!
        }
    }
</script>
