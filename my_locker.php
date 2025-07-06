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
        margin: auto;
    }

    .status-circle {
        background-color: rgb(255, 136, 0);
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
                <h4 class="mb-4 fw-bold">ตู้ของฉัน</h4>
    
                <?php 
                $stmt = $conn->prepare(" SELECT user_locker.locker_id, user_locker.locker_number, locker_status.loadcell_kg 
                                                FROM user_locker 
                                                INNER JOIN locker_status ON user_locker.locker_id = locker_status.locker_id
                                                WHERE user_locker.user_id = ?
                ");
                $stmt->bind_param("s", $_SESSION['userid']);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0){
                    while ($row = $result->fetch_assoc()){?>
                        <!-- ด้านซ้าย: การ์ดตู้ -->
                        <div class="col-sm-4 col-5 ">
                            <div class="card text-center shadow-sm p-3" style="border-radius: 15px;">
                                <div class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-warning text-dark">
                                    ตู้ของคุณ
                                </div>
                                <img src="img/logo.png" class="img-fluid mx-auto mb-2" style="max-height: 100px;" alt="logo">
                                <h5 class="text-muted">ตู้ฝากของ</h5>
                                <h3><?php echo $row["locker_number"]; ?></h3>

                            </div>
                        </div>
                            
                        <!-- ด้านขวา: กล่องแสดงรายละเอียด (ซ่อนไว้ก่อน) -->
                        <div class="col-md-8 col-7">
                            <div class="border p-4  " style="border-radius: 15px;">
                                <h4><i class="bi bi-person-fill"></i> <span id="detail-username"></span> <?php echo $_SESSION["username"]?></h4>
                                <p>หมายเลขตู้: <strong id="detail-lockernumber"> <?php echo $row["locker_number"]?> </strong></p>
                                <p>น้ำหนักในตู้: <strong id="detail-weight"></strong> กก. <?php echo $row["loadcell_kg"]?></p>
                                <br>
                                <button class="btn btn-success">เปลี่ยนรหัสผ่านตู้</button>
                                <button class="btn btn-danger" onclick="cancelLocker()">ยกเลิกใช้ตู้</button>
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
function cancelLocker() {
    Swal.fire({
        title: "คุณแน่ใจหรือไม่?",
        text: "คุณต้องการยกเลิกการใช้ตู้นี้?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "ใช่, ยกเลิก",
        cancelButtonText: "ยกเลิก"
    }).then((result) => {
        if (result.isConfirmed) {
            // TODO: ทำการยกเลิกผ่าน fetch หรือ form
            Swal.fire("ยกเลิกสำเร็จ", "คุณยกเลิกการใช้ตู้เรียบร้อยแล้ว", "success").then(() => {
                location.reload(); // หรือซ่อน detail box ก็ได้
            });
        }
    });
}
</script>

</body>

</html>