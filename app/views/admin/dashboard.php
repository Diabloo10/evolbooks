<?php
/** @var int $totalBooks */
/** @var int $totalUsers */
/** @var int $totalLikes */
/** @var int $totalViews */
/** @var int $totalMessages */

/** @var array $trendingBooks */
/** @var array $recentUsers */
/** @var array $contacts */

/** @var array $topViewedBooks */
/** @var array $topLikedBooks */

/** @var int $page */
/** @var int $totalPages */

$currentUrl = $_SERVER['REQUEST_URI'];
?>

<div class="admin-layout">

<!-- SIDEBAR -->

<div class="admin-sidebar">

<div>

<h2 class="sidebar-logo">
EvolAdmin
</h2>

<ul class="sidebar-menu">

<li>
<a href="/evol/public/admin/dashboard"
class="<?= str_contains($currentUrl,'/admin/dashboard') ? 'active' : '' ?>">

 Dashboard

</a>
</li>

<li>
<a href="/evol/public/adminbook/index"
class="<?= str_contains($currentUrl,'/adminbook') ? 'active' : '' ?>">

 Books

</a>
</li>

<li>
<a href="/evol/public/adminuser/index"
class="<?= str_contains($currentUrl,'/adminuser') ? 'active' : '' ?>">

 Users

</a>
</li>

<li>
<a href="/evol/public/admincontact/index"
class="<?= str_contains($currentUrl,'/admincontact') ? 'active' : '' ?>">

 Messages

</a>
</li>

<li>
<a href="/evol/public/profile">

👤 Profile

</a>
</li>

</ul>

</div>

<a href="/evol/public/auth/logout" class="logout-btn">

 Logout

</a>

</div>


<!-- MAIN -->

<div class="admin-main">

<!-- HEADER -->

<div class="dashboard-header">

<div>

<h1>Admin Dashboard</h1>

<p>
Professional analytics and management system
</p>

</div>


<!-- NOTIFICATIONS -->

<div class="notification-wrapper">

<div class="notification-bell"
id="notificationBell">

🔔

<span class="notification-count">

<?= count($contacts) + count($recentUsers) ?>

</span>

</div>


<!-- DROPDOWN -->

<div class="notification-dropdown"
id="notificationDropdown">

<h5 class="notification-title">

Notifications

</h5>


<!-- EMPTY STATE -->

<?php if(empty($contacts) && empty($recentUsers)): ?>

<div class="text-center text-muted py-4">

No notifications yet

</div>

<?php endif; ?>


<!-- CONTACTS -->

<?php foreach($contacts as $contact): ?>

<div class="notification-item">

<div class="notification-icon">



</div>

<div>

<h6>

<?= htmlspecialchars($contact['name']) ?>

</h6>

<p>

Sent a new contact message

</p>

</div>

</div>

<?php endforeach; ?>


<!-- USERS -->

<?php foreach($recentUsers as $user): ?>

<div class="notification-item">

<div class="notification-icon user-icon">

👤

</div>

<div>

<h6>

<?= htmlspecialchars($user['username']) ?>

</h6>

<p>

New user registered

</p>

</div>

</div>

<?php endforeach; ?>

</div>

</div>

</div>


<!-- STATS -->

<div class="row g-4 mb-5">

<div class="col-lg-3 col-md-6">

<div class="stats-card">

<div class="stats-icon">📚</div>

<h2><?= $totalBooks ?></h2>

<p>Total Books</p>

</div>

</div>


<div class="col-lg-3 col-md-6">

<div class="stats-card">

<div class="stats-icon">👥</div>

<h2><?= $totalUsers ?></h2>

<p>Total Users</p>

</div>

</div>


<div class="col-lg-3 col-md-6">

<div class="stats-card">

<div class="stats-icon">❤️</div>

<h2><?= $totalLikes ?></h2>

<p>Total Likes</p>

</div>

</div>


<div class="col-lg-3 col-md-6">

<div class="stats-card">

<div class="stats-icon">👁</div>

<h2><?= $totalViews ?></h2>

<p>Total Views</p>

</div>

</div>

</div>


<!-- QUICK ACTIONS -->

<div class="quick-actions mb-5">

<a href="/evol/public/adminbook/create"
class="quick-btn">

➕ Add Book

</a>

<a href="/evol/public/adminuser/index"
class="quick-btn">

👥 Manage Users

</a>

<a href="/evol/public/admincontact/index"
class="quick-btn">

📩 Contacts

</a>

</div>


<!-- CHARTS -->

<div class="row g-4 mb-5">

<!-- VIEWS -->

<div class="col-lg-6">

<div class="dashboard-card">

<h3 class="dashboard-title mb-4">

📈 Most Viewed Books

</h3>

<canvas id="viewsChart"></canvas>

</div>

</div>


<!-- LIKES -->

<div class="col-lg-6">

<div class="dashboard-card">

<h3 class="dashboard-title mb-4">

❤️ Most Liked Books

</h3>

<canvas id="likesChart"></canvas>

</div>

</div>

</div>


<!-- TRENDING BOOKS -->

<div class="dashboard-card mb-5">

<div class="d-flex justify-content-between align-items-center mb-4">

<h3 class="dashboard-title">

Trending Books

</h3>

<input
id="bookSearch"
type="text"
class="admin-search"
placeholder="🔍 Search books...">

</div>


<div class="table-responsive">

<table class="table admin-table align-middle">

<thead>

<tr>

<th>Cover</th>
<th>Title</th>
<th>Author</th>
<th>Likes</th>
<th>Views</th>
<th>Action</th>

</tr>

</thead>

<tbody id="booksTable">

<?php foreach($trendingBooks as $book): ?>

<tr class="book-row">

<td>

<img
src="/evol/storage/uploads/<?= htmlspecialchars($book['cover_image']) ?>"
class="table-book-img">

</td>

<td class="book-title-cell">

<?= htmlspecialchars($book['title']) ?>

</td>

<td>

<?= htmlspecialchars($book['author']) ?>

</td>

<td>

❤️ <?= $book['like_count'] ?>

</td>

<td>

👁 <?= $book['view_count'] ?>

</td>

<td>

<a href="/evol/public/adminbook/edit/<?= $book['id'] ?>"
class="table-btn">

Edit

</a>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>


<!-- PAGINATION -->

<div class="pagination-wrapper mt-4">

<?php if($page > 1): ?>

<a href="?page=<?= $page - 1 ?>"
class="pagination-btn">

← Previous

</a>

<?php endif; ?>


<?php for($i = 1; $i <= $totalPages; $i++): ?>

<a href="?page=<?= $i ?>"
class="pagination-btn <?= $i == $page ? 'active-page' : '' ?>">

<?= $i ?>

</a>

<?php endfor; ?>


<?php if($page < $totalPages): ?>

<a href="?page=<?= $page + 1 ?>"
class="pagination-btn">

Next →

</a>

<?php endif; ?>

</div>

</div>


<!-- RECENT USERS -->

<div class="dashboard-card mb-5">

<h3 class="dashboard-title mb-4">

Recent Users

</h3>

<div class="table-responsive">

<table class="table admin-table align-middle">

<thead>

<tr>

<th>ID</th>
<th>Username</th>
<th>Email</th>
<th>Role</th>

</tr>

</thead>

<tbody>

<?php foreach($recentUsers as $user): ?>

<tr>

<td><?= $user['id'] ?></td>

<td><?= htmlspecialchars($user['username']) ?></td>

<td><?= htmlspecialchars($user['email']) ?></td>

<td>

<span class="role-badge">

<?= htmlspecialchars($user['role']) ?>

</span>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

</div>


<!-- CONTACTS -->

<div class="dashboard-card">

<h3 class="dashboard-title mb-4">

Latest Messages

</h3>

<?php foreach($contacts as $contact): ?>

<div class="message-box">

<h6>

<?= htmlspecialchars($contact['name']) ?>

</h6>

<p>

<?= htmlspecialchars($contact['message']) ?>

</p>

</div>

<?php endforeach; ?>

</div>

</div>

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

/* SEARCH */

const searchInput =
document.getElementById('bookSearch');

searchInput.addEventListener('keyup', function(){

    let value =
    this.value.toLowerCase();

    let rows =
    document.querySelectorAll('.book-row');

    rows.forEach(row => {

        let title =
        row.querySelector('.book-title-cell')
        .innerText
        .toLowerCase();

        if(title.includes(value)){
            row.style.display = '';
        }
        else{
            row.style.display = 'none';
        }

    });

});


/* CHART DATA */

const viewedLabels = [

<?php foreach($topViewedBooks as $book): ?>

"<?= addslashes($book['title']) ?>",

<?php endforeach; ?>

];

const viewedData = [

<?php foreach($topViewedBooks as $book): ?>

<?= $book['total_views'] ?>,

<?php endforeach; ?>

];


const likesLabels = [

<?php foreach($topLikedBooks as $book): ?>

"<?= addslashes($book['title']) ?>",

<?php endforeach; ?>

];

const likesData = [

<?php foreach($topLikedBooks as $book): ?>

<?= $book['total_likes'] ?>,

<?php endforeach; ?>

];


/* VIEWS CHART */

new Chart(
document.getElementById('viewsChart'),

{
    type:'bar',

    data:{

        labels:viewedLabels,

        datasets:[{

            label:'Views',

            data:viewedData,

            backgroundColor:[
                '#22c55e',
                '#3b82f6',
                '#ec4899',
                '#8b5cf6',
                '#f59e0b'
            ],

            borderRadius:12

        }]
    },

    options:{

        responsive:true,

        animation:{
            duration:1500
        },

        plugins:{
            legend:{
                display:false
            }
        }
    }
});


/* LIKES CHART */

new Chart(
document.getElementById('likesChart'),

{
    type:'doughnut',

    data:{

        labels:likesLabels,

        datasets:[{

            data:likesData,

            backgroundColor:[
                '#22c55e',
                '#3b82f6',
                '#ec4899',
                '#8b5cf6',
                '#f59e0b'
            ],

            borderWidth:0

        }]
    },

    options:{
        responsive:true,
        animation:{
            animateRotate:true
        }
    }
});


/* NOTIFICATIONS */

const bell =
document.getElementById('notificationBell');

const dropdown =
document.getElementById('notificationDropdown');

bell.addEventListener('click', function(e){

    e.stopPropagation();

    dropdown.classList.toggle('show-dropdown');

});

document.addEventListener('click', function(){

    dropdown.classList.remove('show-dropdown');

});

</script>