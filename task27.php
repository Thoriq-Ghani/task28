<?php
// task27.php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$host = 'localhost';
$dbname = 'task27';
$user = 'root';
$password = '';

$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

$limit = 10; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page > 1) ? ($page * $limit) - $limit : 0;

$orderBy = isset($_GET['orderby']) ? $_GET['orderby'] : 'id';
$direction = isset($_GET['direction']) && $_GET['direction'] === 'DESC' ? 'DESC' : 'ASC';

$query = "SELECT * FROM mobile_phones ORDER BY $orderBy $direction LIMIT $start, $limit";
$stmt = $conn->prepare($query);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalQuery = $conn->query("SELECT COUNT(*) FROM mobile_phones");
$totalRows = $totalQuery->fetchColumn();
$totalPages = ceil($totalRows / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel dengan Sorting dan Pagination</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo $_SESSION['username']; ?>! <a href="logout.php" class="btn-logout">Logout</a></h2>
        
        <table>
            <thead>
                <tr>
                    <th><a href="?orderby=tanggal&direction=<?php echo $direction === 'ASC' ? 'DESC' : 'ASC'; ?>">Tanggal</a></th>
                    <th><a href="?orderby=nik&direction=<?php echo $direction === 'ASC' ? 'DESC' : 'ASC'; ?>">NIK</a></th>
                    <th><a href="?orderby=nama&direction=<?php echo $direction === 'ASC' ? 'DESC' : 'ASC'; ?>">Nama</a></th>
                    <th><a href="?orderby=harga&direction=<?php echo $direction === 'ASC' ? 'DESC' : 'ASC'; ?>">Harga</a></th>
                    <th><a href="?orderby=kuantitas&direction=<?php echo $direction === 'ASC' ? 'DESC' : 'ASC'; ?>">Kuantitas</a></th>
                    <th><a href="?orderby=total&direction=<?php echo $direction === 'ASC' ? 'DESC' : 'ASC'; ?>">Total</a></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?php echo $row['tanggal']; ?></td>
                        <td><?php echo $row['nik']; ?></td>
                        <td><?php echo $row['nama']; ?></td>
                        <td><?php echo $row['harga']; ?></td>
                        <td><?php echo $row['kuantitas']; ?></td>
                        <td><?php echo $row['total']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>&orderby=<?php echo $orderBy; ?>&direction=<?php echo $direction; ?>">Prev</a>
            <?php else: ?>
                <span>Prev</span>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <?php if ($i == $page): ?>
                    <span class="active"><?php echo $i; ?></span>
                <?php else: ?>
                    <a href="?page=<?php echo $i; ?>&orderby=<?php echo $orderBy; ?>&direction=<?php echo $direction; ?>"><?php echo $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo $page + 1; ?>&orderby=<?php echo $orderBy; ?>&direction=<?php echo $direction; ?>">Next</a>
            <?php else: ?>
                <span>Next</span>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
