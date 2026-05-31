<?php
/** @var array $book */
/** @var array $genres */
/** @var array $recommended */
/** @var int $likeCount */
/** @var bool $userLiked */
?>

<div class="container py-5">

<div class="row align-items-start g-5">

<!-- =========================
     BOOK COVER
========================= -->

<div class="col-lg-4 text-center">

<div class="book-image-container" data-id="<?= $book['id'] ?>">

<img 
src="/evol/storage/uploads/<?= htmlspecialchars($book['cover_image']) ?>" 
class="book-cover img-fluid">

<span class="floating-heart">❤</span>

</div>

<a href="/evol/public/reader/index/<?= urlencode($book['id']) ?>"
class="btn btn-dark mt-3"
target="_blank">

Start Reading →

</a>

</div>


<!-- =========================
     BOOK INFO
========================= -->

<div class="col-lg-8">

<h1 class="book-title">
<?= htmlspecialchars($book['title']) ?>
</h1>

<h5 class="book-author">
<?= htmlspecialchars($book['author']) ?>
</h5>


<!-- GENRES -->

<div class="book-genres mb-3">

<?php foreach($genres as $genre): ?>

<span class="genre-badge">
<?= htmlspecialchars($genre) ?>
</span>

<?php endforeach; ?>

</div>


<!-- DESCRIPTION -->

<p class="book-description">
<?= htmlspecialchars($book['description']) ?>
</p>

<div class="mt-3 d-flex align-items-center gap-3">

<button 
class="like-btn <?= $userLiked ? 'liked' : '' ?>" 
data-id="<?= $book['id'] ?>">

<span class="heart">❤</span>

</button>

<span class="like-count" id="likeCount">

<?= $likeCount ?> likes

</span>

</div>

<hr>


<!-- BOOK DETAILS -->

<div class="row">

<div class="col-md-6">

<p><strong>Language</strong></p>

<p>
<?= htmlspecialchars($book['language']) ?>
</p>

</div>

<div class="col-md-6">

<p><strong>ISBN</strong></p>

<p>
<?= htmlspecialchars($book['isbn']) ?>
</p>

</div>

</div>

</div>

</div>

<?php if(!empty($recommended)): ?>

<h4 class="mt-5 mb-3">
Recommended Books
</h4>

<div class="row">

<?php foreach($recommended as $rec): ?>

<div class="col-md-3">

<div class="card shadow-sm mb-3">

<img
src="/evol/storage/uploads/<?= $rec['cover_image'] ?>"
class="card-img-top"
style="height:200px; object-fit:cover;">

<div class="card-body text-center">

<h6>
<?= htmlspecialchars($rec['title']) ?>
</h6>

<a href="/evol/public/books/show/<?= $rec['id'] ?>"
class="btn btn-sm btn-primary">

View

</a>

</div>

</div>

</div>

<?php endforeach; ?>

</div>

<?php endif; ?>

</div>


<script>

/* =========================
   LIKE BUTTON CLICK
========================= */

document.querySelector('.like-btn').addEventListener('click', function(){

    let btn = this;

    let bookId = btn.getAttribute('data-id');

    fetch('/evol/public/books/like/' + bookId)

    .then(res => res.json())

    .then(data => {

        if(data.error){

            alert("Please login first");

            return;
        }

        /* Toggle Like */

        if(data.liked){

            btn.classList.add('liked');

        } 
        else {

            btn.classList.remove('liked');
        }

        /* Update Count */

        document.getElementById('likeCount').innerText = 
            data.count + " likes";

        /* Button Animation */

        btn.classList.add('animate');

        setTimeout(() => {

            btn.classList.remove('animate');

        }, 300);

    });

});


/* =========================
   DOUBLE CLICK IMAGE LIKE
========================= */

document.querySelector('.book-image-container').addEventListener('dblclick', function(){

    let container = this;

    let bookId = container.getAttribute('data-id');

    let btn = document.querySelector('.like-btn');

    /* Already liked */

    if(btn.classList.contains('liked')){

        return;
    }

    fetch('/evol/public/books/like/' + bookId)

    .then(res => res.json())

    .then(data => {

        if(data.error){

            alert("Login required");

            return;
        }

        /* Add Like */

        btn.classList.add('liked');

        /* Update Count */

        document.getElementById('likeCount').innerText = 
            data.count + " likes";

        /* Floating Heart Animation */

        let heart = container.querySelector('.floating-heart');

        heart.classList.add('show');

        setTimeout(() => {

            heart.classList.remove('show');

        }, 800);

    });

});

</script>