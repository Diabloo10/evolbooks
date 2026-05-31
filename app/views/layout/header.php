<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>EvolBooks</title>

<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link rel="stylesheet" href="/evol/public/assets/css/style.css">

</head>

<body>

<nav class="navbar navbar-expand-lg mb-3 border-bottom">

<div class="container-fluid">

<a class="navbar-brand" href="/evol/public/">
<img id="brandimg"
src="/evol/public/assets/images/evolBooks.png"
alt="Logo"
height="80"
width="80">
</a>

<button class="navbar-toggler shadow-none border-0"
type="button"
data-bs-toggle="offcanvas"
data-bs-target="#offcanvasNavbar">

<span class="navbar-toggler-icon"></span>

</button>

<div class="sidebar offcanvas offcanvas-start"
tabindex="-1"
id="offcanvasNavbar">

<div class="offcanvas-header border-bottom border-white m-3">

<h5 class="offcanvas-title">EvolBooks</h5>

<button type="button"
class="btn-close"
data-bs-dismiss="offcanvas">
</button>

</div>

<div class="offcanvas-body d-flex flex-column flex-lg-row p-4 p-lg-0">

<ul class="navbar-nav justify-content-center align-items-center fs-4 flex-grow-1 pe-3">

<li class="nav-item mx-3">
<a class="nav-link" href="/evol/public/">Home</a>
</li>

<li class="nav-item mx-3">
<a class="nav-link" href="/evol/public/about">About</a>
</li>

<li class="nav-item mx-3">
<a class="nav-link" href="/evol/public/books">Books</a>
</li>

<li class="nav-item mx-3">
<a class="nav-link" href="/evol/public/contact">Contact</a>
</li>

<?php if(isset($_SESSION['role']) && $_SESSION['role']=='admin'): ?>

<li class='nav-item mx-3'>
<a class='nav-link' href='/evol/public/admin/dashboard'>
Dashboard
</a>
</li>

<?php endif; ?>

</ul>

<div class="login-btn d-flex justify-content-center align-items-center">

<?php if(isset($_SESSION['user_id'])): ?>

<div class="dropdown">

<button class="btn btn-success dropdown-toggle px-3 py-2 mx-2 rounded-5 border-0"
type="button"
data-bs-toggle="dropdown"
aria-expanded="false">

<?= htmlspecialchars($_SESSION['username']) ?>

</button>

<ul class="dropdown-menu">

<li>
<a class="dropdown-item" href="/evol/public/profile">
Profile
</a>
</li>

<li>
<a class="dropdown-item" href="/evol/public/auth/logout">
Logout
</a>
</li>

</ul>

</div>

<?php else: ?>

<a class="btn btn-success px-3 py-2 mx-2 rounded-5 border-0"
href="/evol/public/auth/login">
Login
</a>

<a class="btn btn-success px-3 py-2 mx-2 rounded-5 border-0"
href="/evol/public/auth/register">
Register
</a>

<?php endif; ?>

</div>

</div>

</div>

</div>

</nav>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>