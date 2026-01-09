    <header>
        <h1>Équipes – Apex Manager</h1>
        <nav>
            <?php  if ($_SESSION['user']['role'] === 'admin'): ?>
                <a href="/../Apex_Mercato/roles/index.php">Dashboard Admin</a>
            <?php endif; ?>
            <a href="logout.php">Déconnexion</a>
        </nav>
    </header>