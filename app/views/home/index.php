<?php 
/** @var array $books */
?>

<div class="container py-4">

<div id="carouselExampleAutoplaying"
class="carousel slide modern-carousel mb-5"
data-bs-ride="carousel">

<div class="carousel-inner rounded-4 overflow-hidden shadow-lg">

<div class="carousel-item active">

<img src="/evol/public/assets/images/book3.jpeg"
class="carousel-img w-100">

<div class="carousel-overlay"></div>

<div class="carousel-caption custom-caption">

<span class="hero-badge">
    Welcome to EvolBooks
</span>

<h1>
Discover Your Next Favorite Book
</h1>

<p>
Thousands of stories waiting for you.
Explore books loved by readers.
</p>

<a href="/evol/public/books"
class="btn hero-btn">

Explore Library

</a>

</div>

</div>


<div class="carousel-item">

<img src="/evol/public/assets/images/book1.jpeg"
class="carousel-img w-100">

<div class="carousel-overlay"></div>

<div class="carousel-caption custom-caption">

<span class="hero-badge">
 Trending Reads
</span>

<h1>
Read Anywhere Anytime
</h1>

<p>
Continue your reading journey from any device.
</p>

<a href="/evol/public/books"
class="btn hero-btn">

Start Reading

</a>

</div>

</div>

</div>

<button class="carousel-control-prev"
data-bs-target="#carouselExampleAutoplaying"
data-bs-slide="prev">

<span class="carousel-control-prev-icon"></span>

</button>

<button class="carousel-control-next"
data-bs-target="#carouselExampleAutoplaying"
data-bs-slide="next">

<span class="carousel-control-next-icon"></span>

</button>

</div>


<!-- =========================
     CATEGORY FILTER
========================= -->

<div class="text-center mb-5">

<button class="category-btn active"
data-category="all">

All

</button>

<button class="category-btn"
data-category="fiction">

Fiction

</button>

<button class="category-btn"
data-category="history">

History

</button>

<button class="category-btn"
data-category="science">

Science

</button>

<button class="category-btn"
data-category="philosophy">

Philosophy

</button>

</div>


<!-- =========================
     TRENDING SECTION
========================= -->

<div class="section-heading">

<h2>
🔥 Trending This Week
</h2>

<p>
Most viewed and liked books by readers
</p>

</div>


<div class="row mb-5">

<?php foreach($books as $book): ?>

<div class="col-lg-3 col-md-4 col-sm-6 mb-4 book-item"
data-genre="<?= strtolower($book['genres']) ?>">

<div class="modern-book-card">

<div class="book-image-wrapper">

<a href="#"
class="book-link"
data-id="<?= $book['id'] ?>">

<img src="/evol/storage/uploads/<?= htmlspecialchars($book['cover_image']) ?>"
class="modern-book-image">

</a>

<div class="book-hover-overlay">

<a href="#"
class="btn read-now-btn book-link"
data-id="<?= $book['id'] ?>">

Read Now

</a>

</div>

</div>

<div class="book-content">

<span class="genre-badge-card">

<?= explode(',', $book['genres'])[0] ?>

</span>

<h5 class="book-title-card">

<?= htmlspecialchars($book['title']) ?>

</h5>

<p class="book-author-card">

by <?= htmlspecialchars($book['author'] ?? 'Unknown Author') ?>

</p>

<div class="book-stats">

<span>
❤️ <?= $book['like_count'] ?>
</span>

<span>
👁 <?= $book['view_count'] ?>
</span>

</div>

</div>

</div>

</div>

<?php endforeach; ?>

</div>


<!-- =========================
     FEATURED SECTION
========================= -->

<?php if(!empty($featured)): ?>

<div class="featured-banner mb-5">

<div class="row align-items-center">

<div class="col-lg-7">

<span class="featured-tag">
⭐ Featured Book
</span>

<h2 class="featured-title mt-3">

<?= htmlspecialchars($featured['title']) ?>

</h2>

<p class="featured-description">

<?= htmlspecialchars(substr($featured['description'],0,220)) ?>...

</p>

<div class="featured-meta mb-4">

<span class="featured-pill">
❤️ <?= $featured['like_count'] ?> Likes
</span>

<span class="featured-pill">
👁 <?= $featured['view_count'] ?> Views
</span>

<span class="featured-pill">

<?= explode(',', $featured['genres'])[0] ?>

</span>

</div>

<a href="#"
class="btn featured-btn book-link"
data-id="<?= $featured['id'] ?>">

Read Now

</a>

</div>

<div class="col-lg-5 text-center">

<img src="/evol/storage/uploads/<?= htmlspecialchars($featured['cover_image']) ?>"
class="featured-image img-fluid">

</div>

</div>

</div>

<?php endif; ?>


<!-- =========================
     RECENTLY ADDED
========================= -->

<div class="section-heading">

<h2>
📚 Recently Added
</h2>

<p>
Fresh uploads added recently
</p>

</div>

<div class="row mb-5">

<?php foreach($books as $book): ?>

<div class="col-lg-3 col-md-4 col-sm-6 mb-4">

<div class="small-book-card">

<img src="/evol/storage/uploads/<?= htmlspecialchars($book['cover_image']) ?>"
class="small-book-image">

<div class="small-book-content">

<h6>

<?= htmlspecialchars($book['title']) ?>

</h6>

<p>

<?= htmlspecialchars($book['author']) ?>

</p>

</div>

</div>

</div>

<?php endforeach; ?>

</div>


<!-- =========================
     CTA SECTION
========================= -->

<div class="cta-section text-center mt-5">

<h2>
Start Reading Today
</h2>

<p>
Find books you'll love and continue your reading journey.
</p>

<a href="/evol/public/books"
class="btn cta-btn">

Explore Books

</a>

</div>

</div>
<!-- =========================
     LOGIN REQUIRED MODAL
========================= -->

<div class="modal fade"
id="loginModal"
tabindex="-1">

<div class="modal-dialog modal-dialog-centered">

<div class="modal-content login-modal">

<div class="modal-body text-center p-5">

<div class="login-icon mb-4">

📚

</div>

<h3 class="login-title mb-3">

Login Required

</h3>

<p class="login-text mb-4">

Please login first to continue reading books.

</p>

<div class="d-flex justify-content-center gap-3">

<button
type="button"
class="btn modal-cancel-btn"
data-bs-dismiss="modal">

Cancel

</button>

<a href="/evol/public/auth/login"
class="btn modal-login-btn">

Login Now

</a>

</div>

</div>

</div>

</div>

</div>


<script>

/* CATEGORY FILTER */

const categoryButtons = document.querySelectorAll('.category-btn');

categoryButtons.forEach(btn => {

    btn.addEventListener('click', function(){

        categoryButtons.forEach(b => b.classList.remove('active'));

        this.classList.add('active');

        let category = this.dataset.category.toLowerCase();

        document.querySelectorAll('.book-item').forEach(book => {

            let genres = book.dataset.genre || "";

            if(category === 'all' || genres.includes(category)){
                book.style.display = 'block';
            }
            else{
                book.style.display = 'none';
            }

        });

    });

});


/* BOOK CLICK */

const isLoggedIn = <?= isset($_SESSION['user_id']) ? 'true' : 'false' ?>;

document.querySelectorAll(".book-link").forEach(link => {

    link.addEventListener("click", function(e){

        e.preventDefault();

        let id = this.dataset.id;

        if(!isLoggedIn){

    const loginModal =
    new bootstrap.Modal(
        document.getElementById('loginModal')
    );

    loginModal.show();

    return;
}

        window.location.href = "/evol/public/books/show/" + id;

    });

});

</script>