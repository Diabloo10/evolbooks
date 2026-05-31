<?php 
/** @var array $book */
/** @var array $bookGenres */
/** @var array $genres */
?>

<div class="container mt-4 mb-5">

<div class="card shadow-lg">

<div class="card-header bg-dark text-white">
<h4 class="mb-0">Edit Book</h4>
</div>

<div class="card-body">

<form method="POST" enctype="multipart/form-data">

<div class="row">

<!-- LEFT COLUMN -->

<div class="col-md-6">

<div class="mb-3">
<label class="form-label">Title</label>

<input
type="text"
name="title"
class="form-control"
value="<?= htmlspecialchars($book['title']) ?>"
required>

</div>


<div class="mb-3">
<label class="form-label">Author</label>

<input
type="text"
name="author"
class="form-control"
value="<?= htmlspecialchars($book['author']) ?>">

</div>


<div class="mb-3">
<label class="form-label">ISBN</label>

<input
type="text"
name="isbn"
class="form-control"
value="<?= htmlspecialchars($book['isbn']) ?>">

</div>


<div class="mb-3">
<label class="form-label">Language</label>

<input
type="text"
name="language"
class="form-control"
value="<?= htmlspecialchars($book['language']) ?>">

</div>

</div>


<!-- RIGHT COLUMN -->

<div class="col-md-6">

<label class="form-label">Genres</label>

<?php foreach($genres as $genre): ?>

<div class="form-check">

<input
type="checkbox"
name="genres[]"
value="<?= $genre['id'] ?>"
class="form-check-input"

<?php if(in_array($genre['id'],$bookGenres)) echo "checked"; ?>

>

<label class="form-check-label">

<?= htmlspecialchars($genre['name']) ?>

</label>

</div>

<?php endforeach; ?>

</div>

</div>


<!-- DESCRIPTION -->

<div class="mb-3 mt-3">

<label class="form-label">Description</label>

<textarea
name="description"
class="form-control"
rows="4"><?= htmlspecialchars($book['description']) ?></textarea>

</div>


<!-- FILE UPLOADS -->

<div class="row">

<!-- COVER IMAGE -->

<div class="col-md-6">

<label class="form-label">Cover Image</label>

<input
type="file"
name="cover_image"
class="form-control"
accept="image/*"
onchange="previewCover(event)">

<div class="mt-2">

<img
id="coverPreview"
src="/evol/storage/uploads/<?= $book['cover_image'] ?>"
width="140"
class="rounded shadow">

</div>

</div>


<!-- PDF FILE -->

<div class="col-md-6">

<label class="form-label">PDF File</label>

<input
type="file"
name="pdf_file"
class="form-control"
accept="application/pdf"
onchange="showPdfName(event)">

<div class="mt-2">

<?php if(!empty($book['pdf_file'])): ?>

<a
href="/evol/storage/uploads/<?= $book['pdf_file'] ?>"
target="_blank"
class="btn btn-outline-primary btn-sm">

View Current PDF

</a>

<?php endif; ?>

<p id="pdfName" class="text-muted mt-2"></p>

</div>

</div>

</div>


<!-- BUTTONS -->

<div class="mt-4 d-flex justify-content-center gap-3 flex-wrap">

<button class="btn btn-success px-4">

Update Book

</button>

<a href="/evol/public/adminbook"
   class="btn btn-secondary px-4">

Cancel

</a>

</div>

</form>

</div>

</div>

</div>


<script>

/* Cover preview */

function previewCover(event)
{
    const reader = new FileReader();

    reader.onload = function(){
        const output = document.getElementById('coverPreview');
        output.src = reader.result;
    };

    reader.readAsDataURL(event.target.files[0]);
}


/* Show selected PDF name */

function showPdfName(event)
{
    const file = event.target.files[0];

    if(file)
    {
        document.getElementById("pdfName").innerText =
        "Selected file: " + file.name;
    }
}

</script>