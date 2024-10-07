<?php
?>
<header class="" id="main_header">
    <div class="left-container">
        <h4 class="hamburger-icon" id="sidebarBtn"><i class="bi bi-list"></i></h4>
    </div>
    <div class="right-container">
        <img src="<?= ROOT_IMG . "lbrdc-logo.webp" ?>" alt="userLogo" srcset="">
        <span class="text-white"><?= $_SESSION['USER'][0]['admin_username'] ?></span>
    </div>

</header>   