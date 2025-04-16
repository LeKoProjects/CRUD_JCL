<?php
    if (isset($_SESSION['msg'])):
?>

<div>
    <?= $_SESSION['msg']; ?>
</div>

<?php
    unset($_SESSION['msg']);
    endif;
?>