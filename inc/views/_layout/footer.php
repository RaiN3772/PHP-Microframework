<?php
    echo isset($_SESSION["toastr"]) && !empty($_SESSION["toastr"]) ?
    '<script>toastr.' . $_SESSION['toastr']['type'] . '("' . $_SESSION['toastr']['msg'] . '")</script>' : '';
    unset($_SESSION["toastr"]);
    ?>
</body>
</html>