<style>
    .playpen-thai {
        font-family: "Playpen Sans Thai", cursive;
        font-weight: 400;
        font-style: normal;
    }

    .no-underline {
        text-decoration: none;
    }

    h1 {
        font-size: 24px;
        line-height: 30px;
        font-weight: 700;
    }

    .custom-narrow {
        max-width: 1123px;
        /* กำหนดขนาดเอง */
        margin: auto;
        /* จัดตรงกลาง */
    }   
</style>
<?php

if (isset($_POST['logout'])) {
    session_start();
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}
?>
<!-- navbar -->
<div class="container custom-narrow">
    <div class="row align-items-center"style="background-color: #18243dc9; margin: 14px 12px; border-radius: 15px; padding: 1rem 0;">
        <div class="col-sm-6 col-7 d-flex flex-column align-items-start">
            <h1 class="text-white mx-2 playpen-thai">LOCKER FOR ECP</h1>
            <a class="text-white mx-2 playpen-thai no-underline">บริการฝากของ</a>
        </div>
        <div class="col-sm-6 col-5 d-flex justify-content-end align-items-center">
            <a class="bi bi-person-fill"></a>
            <?php
            if (!empty($_SESSION["username"])) {
                echo '<a href="useredit.php" class="text-white mx-2" id="username"  >' . $_SESSION["username"] . '</a>';
                echo '<form method="post">';
                echo '<button  type="submit" class="btn btn-danger text-white mx-2" name="logout" style="border-radius: 15px;">logout</button>';
                echo '</form>';
            } else {
                echo '<a class="text-white mx-2" id="username">ยังไม่ได้LOGIN</a>';
                echo '<form method="post">';
                echo '<button  type="submit" class="btn btn-success text-white mx-2" name="logout" style="border-radius: 15px;">login</button>';
                echo '</form>';
            }
            ?>
        </div>
    </div>
</div>

<!-- end nav -->