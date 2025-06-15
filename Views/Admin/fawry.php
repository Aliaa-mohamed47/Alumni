<?php
session_start();

if (!isset($_SESSION["userRole"])) {
    header("location: ../Auth/login.php");
    exit();
}

$allowedRole = "admin";
if ($_SESSION["userRole"] !== $allowedRole) {
    header("location: ../Auth/login.php");
    exit();
}

require_once '../../Controlers/DBControler.php';

$db = new DBControler();
$db->openConnection();

$donations = $db->select("SELECT alumniId, amount, notes, date FROM donations");

$totalRow = $db->select("SELECT SUM(amount) AS totalAmount FROM donations");
$totalAmount = $totalRow[0]['totalAmount'] ?? 0;
?>

<!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8" />
    <title>Donations Summary</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/images/alumni-removebg-preview.png" />
    <link rel="stylesheet" href="../assets/vendor/css/core.css" />
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>
<?php include 'headerAdmin.php'; ?>

<div class="container-xxl py-5" style="background-color: #16406d; min-height: 100vh;">
    <div class="container bg-light rounded-4 p-4 shadow">
        <div class="text-center mb-4">
            <img src="../assets/images/alumni-removebg-preview.png" style="height: 80px;" alt="">
            <h2 class="mt-3" style="color: #16406d;">Alumni Donations</h2>
            <h4 class="mb-3">Donation Summary</h4>
            <h5>Total Donations: <?php echo number_format($totalAmount, 2); ?> EGP</h5>
        </div>

        <?php if (!empty($donations)) { ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Donor ID</th>
                            <th>Amount</th>
                            <th>Notes</th>
                            <th>Donation Date</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php foreach ($donations as $donation) { ?>
							<tr>
								<td><?php echo htmlspecialchars($donation['alumniId']); ?></td>
								<td><?php echo number_format($donation['amount'], 2); ?> EGP</td>
								<td><?php echo htmlspecialchars($donation['notes']); ?></td>
								<td><?php echo $donation['date']; ?></td>
							</tr>
						<?php } ?>
					</tbody>

                </table>
            </div>
        <?php } else { ?>
            <div class="alert alert-info text-center">
                No donations found.
            </div>
        <?php } ?>
    </div>
</div>

<script src="../assets/vendor/libs/jquery/jquery.js"></script>
<script src="../assets/vendor/libs/popper/popper.js"></script>
<script src="../assets/vendor/js/bootstrap.js"></script>
</body>
</html>
