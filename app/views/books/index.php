<div class="container my-4">

<input type="text"
id="searchInput"
class="form-control"
placeholder="Search books by title...">

<p id="noResult" class="text-center mt-3 text-muted" style="display:none;">
No books found 📚
</p>

</div>


<div class="container py-4">

<div class="row gx-4 gy-3">

<?php if (!empty($books)) : ?>

<?php foreach ($books as $book) : ?>

<div class="col-lg-3 col-md-4 col-sm-6 book-item"
data-title="<?= strtolower(htmlspecialchars($book['title'])) ?>">

<figure class="gallery-grid-item">

<div class="gallery-grid-item-wrapper">

<a href="/evol/public/books/show/<?= $book['id'] ?>">

<img src="/evol/storage/uploads/<?= htmlspecialchars($book['cover_image']) ?>"
alt="<?= htmlspecialchars($book['title']) ?>"
class="gallery-img img-fluid"
loading="lazy">

<div class="book-title-overlay">

<h5><?= htmlspecialchars($book['title']) ?></h5>

</div>

</a>

</div>

</figure>

</div>

<?php endforeach; ?>

<?php else : ?>

<p>No books found.</p>

<?php endif; ?>

</div>

</div>

<script>

const searchInput = document.getElementById("searchInput");

searchInput.addEventListener("keyup", function(){

    let value = this.value.toLowerCase();

    let books = document.querySelectorAll(".book-item");

    let found = false;

    books.forEach(function(book){

        let title = book.getAttribute("data-title");

        if(title.includes(value)){
            book.style.display = "";
            found = true;
        } else {
            book.style.display = "none";
        }

    });

    // optional message
    const noResult = document.getElementById("noResult");

    if(noResult){
        noResult.style.display = found ? "none" : "block";
    }

});

</script>