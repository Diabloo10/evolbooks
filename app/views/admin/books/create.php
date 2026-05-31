<?php 
/** @var array $genres */
?>

<div class="container py-5">

<div class="book-form-container">

<h2 class="book-form-title">
Add New Book
</h2>

<form method="POST" enctype="multipart/form-data">

<!-- Title -->

<div class="mb-3">

<label class="form-label">
Title
</label>

<input type="text"
       name="title"
       class="form-control"
       placeholder="Enter book title"
       required>

</div>

<!-- Author -->

<div class="mb-3">

<label class="form-label">
Author
</label>

<input type="text"
       name="author"
       class="form-control"
       placeholder="Enter author name">

</div>

<!-- ISBN -->

<div class="mb-3">

<label class="form-label">
ISBN
</label>

<input type="text"
       name="isbn"
       class="form-control"
       placeholder="Enter ISBN number">

</div>

<!-- Language -->

<div class="mb-3">

<label class="form-label">
Language
</label>

<input type="text"
       name="language"
       class="form-control"
       placeholder="Enter language">

</div>

<!-- Description -->

<div class="mb-3">

<label class="form-label">
Description
</label>

<textarea name="description"
          class="form-control"
          placeholder="Write short description about the book"></textarea>

</div>

<!-- Genres -->

<div class="mb-3">

<label class="form-label">
Genres
</label>

<div class="genre-box">

<?php foreach($genres as $genre): ?>

<div class="form-check">

<input class="form-check-input"
       type="checkbox"
       name="genres[]"
       value="<?= $genre['id'] ?>">

<label class="form-check-label">

<?= htmlspecialchars($genre['name']) ?>

</label>

</div>

<?php endforeach; ?>

</div>

</div>

<!-- Cover Image -->

<div class="mb-3">

<label class="form-label">
Cover Image
</label>

<input type="file"
       name="cover_image"
       class="form-control">

</div>

<!-- PDF File -->

<div class="mb-4">

<label class="form-label">
PDF File
</label>

<input type="file"
       name="pdf_file"
       class="form-control">

</div>

<!-- Submit Button -->

<button type="submit" class="submit-btn">
Add Book
</button>

</form>

</div>

</div>