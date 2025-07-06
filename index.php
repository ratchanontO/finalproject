<?php
    session_start();
    include 'connectdb.php';
    require "head.php";

    if(!isset($_SESSION["username"])){
        header("Location: login.php");
        exit;
    }
    

    
?>

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
        max-width: 1000px;
        /* กำหนดขนาดเอง */
        margin: auto;
        /* จัดตรงกลาง */
    }

    .status-circle {
        background-color: rgb(255, 136, 0);
        /* สีน้ำเงินแบบ bootstrap */
        color: white;
        border-radius: 50%;
        padding: 8px 12px;
        font-size: 14px;
        font-weight: bold;
        text-align: center;
        min-width: 36px;
        min-height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<body>
    <?php
    require "navbar.php";
    ?>

        <div class="container custom-narrow">
            <div class="row align-items-center"style="background-color:rgba(255, 255, 255, 0.79); margin: 14px 12px; border-radius: 15px; padding: 1rem 0;">
                <h4 class="mb-4 fw-bold">เลือกตู้ที่ต้องการ</h4>

                <?php 
                $sql = "SELECT locker_id, number_locker FROM locker_status where is_owned = 0"; 
                $result = $conn->query($sql);
                if ($result->num_rows > 0){
                    while ($row = $result->fetch_assoc()){?>
                        <div class="col-sm-4 col-6 mt-4 position-relative">
                            <div onclick='setpassword("<?php echo $_SESSION["userid"]; ?>", "<?php echo $row["locker_id"]; ?>", "<?php echo $row["number_locker"]; ?>")'>
                                <div class="card text-center shadow-sm hover-shadow"
                                    style="border-radius: 15px; border: 1px solid black;">
                                    <div class="status-circle position-absolute top-0 start-0 translate-middle-y">ว่าง</div>
                                    <div class="card-body">
                                        <img src="img/logo.png" class="img-fluid mb-2" style="max-height: 100px;">
                                        <h5 class="card-title"><?php echo $row["number_locker"]?></h5>
                                        <h5 class="card-title">ตู้ฝากของ </h5>
                                        <p class="text-primary fw-semibold">คลิกเพื่อตั้งรหัสผ่าน</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php 
                    }
                }
                ?>


                



            </div>
        </div>
    <?php
        require "low_menu.php";
    ?>


<script>
    function setpassword(userid, locker_id, lockerNumber) {
    Swal.fire({
        title: "ตั้งรหัสผ่านสำหรับตู้ " + lockerNumber,
        html:
            '<input id="swal-password" type="password" class="swal2-input" placeholder="รหัสผ่าน">' +
            '<input id="swal-confirm" type="password" class="swal2-input" placeholder="ยืนยันรหัสผ่าน">',
        focusConfirm: false,
        preConfirm: () => {
            const password = document.getElementById('swal-password').value;
            const confirm = document.getElementById('swal-confirm').value;

            if (!password || !confirm) {
                Swal.showValidationMessage("กรุณากรอกรหัสผ่านให้ครบ");
                return;
            }
            if (password !== confirm) {
                Swal.showValidationMessage("รหัสผ่านไม่ตรงกัน");
                return;
            }

            return password;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const password = result.value;

            Swal.showLoading();

            fetch("api/setlocker_pass.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `userid=${encodeURIComponent(userid)}&locker_id=${encodeURIComponent(locker_id)}&locker_number=${encodeURIComponent(lockerNumber)}&password=${encodeURIComponent(password)}`
            })
                .then(res => res.json())
                .then(data => {
                    Swal.close();

                    if (data.success) {
                        Swal.fire("สำเร็จ", data.message, "success").then(() => {
                            location.reload(); // ✅ รีเฟรชหน้าหลังจากกด OK
                        });
                    } else {
                        Swal.fire("ผิดพลาด", data.message, "error");
                    }
                })
                .catch(err => {
                    Swal.close();
                    Swal.fire("เกิดข้อผิดพลาด", err.message, "error");
                });
        }
    });
}

</script>

</body>

</html>