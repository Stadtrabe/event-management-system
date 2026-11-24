<?php 

session_start();
//  Session-Test
echo '<pre>';
print_r($_SESSION);
echo '</pre>';

require_once __DIR__ . '/../layout/header.php'; ?>



<div class="container mt-4">
    <h1>Admin-Dashboard</h1>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>