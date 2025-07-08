<?php
session_start();
include 'connectdb.php';
require "head.php";

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}
?>
<body>
<?php require "navbar.php"; ?>

<div class="container custom-narrow">
    <div class="row align-items-center" style="background-color:rgba(255, 255, 255, 0.79); margin: 14px 12px; border-radius: 15px; padding: 1rem 0;">
        <h4 class="mb-4 fw-bold">ประวัติการใช้งาน</h4>

        <div class="container">
            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th>วันที่และเวลา</th>
                        <th>ตู้</th>
                        <th>ดูประวัติ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // อันนี้จำลองวันที่เฉยๆ
                    $data = [
                        ['date' => '2025-07-08 10:00', 'locker' => '301'],
                        ['date' => '2025-07-07 15:30', 'locker' => '302'],
                        ['date' => '2025-07-06 09:45', 'locker' => '303'],
                    ];

                    foreach ($data as $row): 
                        $inputDate = date('Y-m-d\TH:i', strtotime($row['date']));
                    ?>
                        <tr>
                            <td>
                                <input type="datetime-local" name="date[]" class="form-control" value="<?= $inputDate ?>">
                            </td>
                            <td><?= htmlspecialchars($row['locker']) ?></td>
                            <td>
                                <a href="watch_history.php" class="btn btn-primary btn-sm">ดูประวัติ</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require "low_menu.php"; ?>
</body>