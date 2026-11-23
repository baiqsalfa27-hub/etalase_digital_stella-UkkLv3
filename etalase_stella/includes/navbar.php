<?php
// Variabel dari halaman pemanggil: $base ('' atau '../'), $active ('galeri' | 'siswa' | 'users')
$base   = $base ?? '';
$active = $active ?? '';
?>
<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm border-bottom py-3">
    <div class="container-fluid px-4">
        <!-- Logo dan Judul di Kiri -->
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2 me-4" href="<?= $base ?>index.php">
            <img src="<?= $base ?>assets/img/logo.png" alt="Logo" style="height: 38px; width: auto;">
            <span style="color: #3d0000; font-size: 1.2rem;">Etalase Digital Siswa</span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Menu Tengah / Kiri-Tengah -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-2">
                <li class="nav-item">
                    <a class="nav-link px-3 rounded-pill fw-semibold <?= $active === 'galeri' ? 'text-white' : 'text-dark' ?>" 
                       style="<?= $active === 'galeri' ? 'background-color: #3d0000;' : 'transition: all 0.2s;' ?>" 
                       href="<?= $base ?>index.php">
                       <i class="bi bi-grid-fill me-1"></i> Galeri Karya
                    </a>
                </li>
                <?php if (is_staff()): ?>
                    <li class="nav-item">
                        <a class="nav-link px-3 rounded-pill fw-semibold <?= $active === 'siswa' ? 'text-white' : 'text-dark' ?>" 
                           style="<?= $active === 'siswa' ? 'background-color: #3d0000;' : 'transition: all 0.2s;' ?>" 
                           href="<?= $base ?>admin/siswa.php">
                           <i class="bi bi-people-fill me-1"></i> Kelola Siswa
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (is_super_admin()): ?>
                    <li class="nav-item">
                        <a class="nav-link px-3 rounded-pill fw-semibold <?= $active === 'users' ? 'text-white' : 'text-dark' ?>" 
                           style="<?= $active === 'users' ? 'background-color: #3d0000;' : 'transition: all 0.2s;' ?>" 
                           href="<?= $base ?>admin/users.php">
                           <i class="bi bi-shield-lock-fill me-1"></i> Kelola User
                        </a>
                    </li>
                <?php endif; ?>
            </ul>

            <!-- Bagian Kanan: Halo User & Tombol Logout -->
            <div class="d-flex align-items-center gap-3 ms-auto">
                <div class="d-flex align-items-center gap-2 text-secondary small">
                    <span>Halo, <b class="text-dark"><?= e($_SESSION['nama']) ?></b></span>
                    <span class="badge px-2 py-1 text-white text-uppercase" style="background-color: #3d0000; font-size: 0.7rem;">
                        <?= e(str_replace('_', ' ', $_SESSION['role'])) ?>
                    </span>
                </div>
                <a href="<?= $base ?>auth/logout.php" class="btn btn-sm px-3 text-white fw-semibold rounded-pill shadow-sm" style="background-color: #3d0000; transition: opacity 0.2s;">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </a>
            </div>
        </div>
    </div>
</nav>