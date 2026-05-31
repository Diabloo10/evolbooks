<?php
/** @var array $likedBooks */
/** @var array $recentBooks */
/** @var int $likedCount */
/** @var int $viewedCount */
/** @var int $totalViews */
/** @var array|null $favGenre */
?>

<div class="container py-5">

<!-- PROFILE HEADER -->

<div class="profile-header mb-5">

<div class="profile-avatar">
<?= strtoupper(substr($_SESSION['username'],0,1)) ?>
</div>

<h1 class="profile-name">
<?= htmlspecialchars($_SESSION['username']) ?>
</h1>

<p class="profile-subtitle">
Book Explorer • <?= $likedCount ?> Likes • <?= $totalViews ?> Total Views
</p>

</div>


<!-- STATS -->

<div class="row stats-grid g-4 mb-5">

<div class="col-lg-3 col-md-6">

<div class="stat-card">

<div class="stat-icon">📚</div>

<div class="stat-number">
<?= $viewedCount ?>
</div>

<div class="stat-title">
Books Viewed
</div>

</div>

</div>


<div class="col-lg-3 col-md-6">

<div class="stat-card">

<div class="stat-icon">❤️</div>

<div class="stat-number">
<?= $likedCount ?>
</div>

<div class="stat-title">
Liked Books
</div>

</div>

</div>


<div class="col-lg-3 col-md-6">

<div class="stat-card">

<div class="stat-icon">👀</div>

<div class="stat-number">
<?= $totalViews ?: 0 ?>
</div>

<div class="stat-title">
Total Reads
</div>

</div>

</div>


<div class="col-lg-3 col-md-6">

<div class="stat-card">

<div class="stat-icon">⭐</div>

<div class="stat-number">
<?= $favGenre['name'] ?? 'N/A' ?>
</div>

<div class="stat-title">
Favorite Genre
</div>

</div>

</div>

</div>


<!-- SEARCH -->

<div class="mb-4">

<input type="text"
       id="searchBooks"
       class="form-control profile-search"
       placeholder="🔍 Search liked books...">

</div>


<!-- TABS -->

<ul class="nav nav-pills mb-4">

<li class="nav-item me-2">

<button class="nav-link active"
        data-bs-toggle="pill"
        data-bs-target="#liked">

❤️ Liked Books (<?= count($likedBooks) ?>)

</button>

</li>

<li class="nav-item">

<button class="nav-link"
        data-bs-toggle="pill"
        data-bs-target="#recent">

🕒 Recently Viewed (<?= count($recentBooks) ?>)

</button>

</li>

</ul>


<div class="tab-content">

<!-- LIKED BOOKS -->

<div class="tab-pane fade show active" id="liked">

<?php if(!empty($likedBooks)): ?>

<div class="row" id="booksContainer">

<?php foreach($likedBooks as $book): ?>

<div class="col-lg-3 col-md-4 col-sm-6 mb-4 book-item">

<div class="card book-card h-100">

<img
src="/evol/storage/uploads/<?= htmlspecialchars($book['cover_image']) ?>"
class="card-img-top"
style="height:260px; object-fit:cover;">

<div class="card-body text-center d-flex flex-column">

<h6 class="book-title mb-3">
<?= htmlspecialchars($book['title']) ?>
</h6>

<a href="/evol/public/books/show/<?= $book['id'] ?>"
class="btn btn-success custom-btn mt-auto">

View Book

</a>

</div>

</div>

</div>

<?php endforeach; ?>

</div>

<?php else: ?>

<div class="empty-box">

<div class="empty-icon">📚</div>

<h4>
Your library feels empty
</h4>

<p class="text-muted">
Start exploring books you love.
</p>

<a href="/evol/public/books"
class="btn btn-success custom-btn mt-3">

Explore Books

</a>

</div>

<?php endif; ?>

</div>


<!-- RECENTLY VIEWED -->

<div class="tab-pane fade" id="recent">

<div class="row">

<?php foreach($recentBooks as $book): ?>

<div class="col-lg-3 col-md-4 col-sm-6 mb-4">

<div class="card book-card h-100">

<img
src="/evol/storage/uploads/<?= htmlspecialchars($book['cover_image']) ?>"
class="card-img-top"
style="height:260px; object-fit:cover;">

<div class="card-body text-center d-flex flex-column">

<h6 class="book-title mb-2">
<?= htmlspecialchars($book['title']) ?>
</h6>

<p class="text-muted small">

Viewed:
<?= date('d M Y', strtotime($book['last_viewed_at'])) ?>

</p>

<a href="/evol/public/books/show/<?= $book['id'] ?>"
class="btn btn-outline-success custom-btn mt-auto">

Continue Reading

</a>

</div>

</div>

</div>

<?php endforeach; ?>

</div>

</div>

</div>

</div>


<script>

/* SEARCH FILTER */

const searchInput = document.getElementById('searchBooks');

searchInput.addEventListener('keyup', function(){

    let value = this.value.toLowerCase();

    let books = document.querySelectorAll('.book-item');

    books.forEach(book => {

        let title = book.innerText.toLowerCase();

        if(title.includes(value)){
            book.style.display = 'block';
        }
        else{
            book.style.display = 'none';
        }

    });

});

</script>