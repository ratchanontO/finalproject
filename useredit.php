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
        $stmt = $conn->prepare(" SELECT username, email, status_email, created_at
                                        FROM users
                                        WHERE id = ?
        ");
        $stmt->bind_param("i", $_SESSION['userid']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row['status_email'] == 'active'){
            $status_email = false;
        }else{
            $status_email = true;
        }
        
    
    ?>
        <!-- <div class="container custom-narrow">
            <div class="row align-items-center"style="background-color:rgba(255, 255, 255, 0.79); margin: 14px 12px; border-radius: 15px; padding: 1rem 0;">
                <h4 class="mb-4 fw-bold">ข้อมูลผู้ใช้งาน</h4>

                <div class="col-md-8 col-7">
                    <div class="border p-4  " style="border-radius: 15px;">
                        <h4><i class="bi bi-person-fill"></i> <span id="detail-username"></span>: <?php echo $row['username']?> </h4>
                        <br>
                        <p>Email : <strong id="detail-lockernumber"> <?php echo $row['email']?> </strong></p> <?php if($status_email){echo "กรุณายืนยันอีเมล";}?>
                        <p>สมัครเมื่อ : <strong id="detail-weight"></strong> <?php echo $row['created_at']?> </p>
                        <button class="btn btn-success">เปลี่ยนรหัสผ่าน</button>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="container custom-narrow mt-4">
            <div class="row justify-content-center" >
                <div class="col-md-10 col-11">
                    <div class="card shadow-sm" style="border-radius: 15px;">
                        <div class="card-body">
                            <h4 class="fw-bold mb-4">
                                <i class="fa-solid fa-user-circle me-2"></i> ข้อมูลผู้ใช้งาน
                            </h4>

                            <div class="mb-3">
                                <h5><i class="fa-solid fa-user me-2"></i> ชื่อผู้ใช้: 
                                    <span class="text-primary fw-semibold"><?php echo $row['username'] ?></span>
                                </h5>
                            </div>

                            <div class="mb-3">
                                <i class="fa-solid fa-envelope me-2"></i>
                                อีเมล: 
                                <strong><?php echo $row['email'] ?></strong>
                                <?php if ($status_email): ?>
                                    <span class="badge bg-warning text-dark ms-2">กรุณายืนยันอีเมล</span>
                                    <button class="btn btn-outline-primary">
                                        <i class="fa-solid fa-envelope"></i> ยืนยันอีเมล
                                    </button>
                                <?php else: ?>
                                    <span class="badge bg-success ms-2">ยืนยันแล้ว</span>
                                <?php endif; ?>
                            </div>

                            <div class="mb-4">
                                <i class="fa-solid fa-calendar-check me-2"></i>
                                สมัครเมื่อ: 
                                <strong><?php echo $row['created_at'] ?></strong>
                            </div>

                            <button class="btn btn-outline-primary">
                                <i class="fa-solid fa-key me-2"></i> เปลี่ยนรหัสผ่าน
                            </button>
                        </div>
                    </div>
                </div>
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