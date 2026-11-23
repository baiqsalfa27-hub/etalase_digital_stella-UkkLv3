<?php
require_once '../config/kuis_db.php';
require_once '../middleware/auth_check.php';

// Definisi fungsi helper untuk mengecek error duplicate entry (duplikat email) pada database
if (!function_exists('is_duplicate_error')) {
    function is_duplicate_error($e) {
        return isset($e->errorInfo[1]) && $e->errorInfo[1] == 1062;
    }
}

if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = trim($_POST['nama'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($nama === '' || $email === '' || $password === '') {
        $error = "Semua kolom wajib diisi!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid!";
    } elseif (strlen($password) < 6) {
        $error = "Password minimal 6 karakter!";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO users (nama, email, password, role) VALUES (:nama, :email, :password, 'siswa')");
            $stmt->execute([
                ':nama'     => $nama,
                ':email'    => $email,
                ':password' => password_hash($password, PASSWORD_DEFAULT),
            ]);
            $success = "Pendaftaran berhasil! Silakan login.";
        } catch (PDOException $ex) {
            $error = is_duplicate_error($ex)
                ? "Email sudah terdaftar, silakan gunakan email lain atau login."
                : "Terjadi kesalahan saat mendaftar.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Siswa - Etalase Digital Stella</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>

<div class="main-container">
    <div class="card card-login my-4">
        <div class="text-center mb-4">
            <img src="../assets/img/logo.png" alt="Logo" style="max-height: 42px; width: auto;" class="mb-3">
            <h3 class="fw-bold fs-4 mb-1">Daftar Siswa</h3>
            <p class="text-muted small mb-0">Buat akun untuk memamerkan karya digitalmu</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger py-2 small" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i><?= e($error) ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success py-2 small" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i><?= e($success) ?>
                <div class="mt-2">
                    <a href="login.php" class="btn btn-sm w-100 text-white" style="background-color: #3d0000;">Ke Halaman Login</a>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!$success): ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap" value="<?= e($_POST['nama'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email Sekolah</label>
                <input type="email" name="email" class="form-control" placeholder="nama@stella.sch.id" value="<?= e($_POST['email'] ?? '') ?>" required>
            </div>
            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Buat password" minlength="6" required>
            </div>
            <button type="submit" class="btn w-100 mb-3 text-white" style="background-color: #3d0000;">Daftar Sekarang</button>
        </form>
        <?php endif; ?>

        <div class="text-center pt-2">
            <span class="text-muted small">Sudah punya akun? </span>
            <a href="login.php" class="small text-decoration-none fw-bold" style="color: #3d0000;">Login di sini</a>
        </div>
    </div>
</div>

<footer>
    &copy; 2026 Etalase Stella Digital &bull; Baiq Salfa Sheyna Arfani
</footer>

</body>
</html>