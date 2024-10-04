<?php
?>
<header>
    <div class="left-container">
        <img src="<?= ROOT_IMG ?>lbrdc-logo.webp" alt="lbp_logo" />
        <h2>LBP RESOURCES AND DEVELOPMENT CORPORATION</h2>
    </div>
    <div class="right-container">
        <span class="text-white"><?= $_SESSION['USER'][0]['admin_username'] ?></span>
        <img src="https://images.pexels.com/photos/28627459/pexels-photo-28627459/free-photo-of-black-and-white-cat-by-maiden-s-tower-istanbul.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load"
            alt="mycat">
        <button class="btn btn-danger" name="logoutBtn" data-bs-toggle="modal"
            data-bs-target="#logoutModal">Logout</button>

    </div>

</header>