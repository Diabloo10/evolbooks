<?php 
/** @var array $user */

?>
<?php

if(isset($_SESSION['contact_success'])):

?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

window.onload = function(){

    Swal.fire({

        icon: 'success',

        title: 'Message Sent Successfully 📚',

        text: 'Thank you for contacting EvolBooks. We will get back to you within 24 hours.',

        confirmButtonColor: '#22c55e',

        confirmButtonText: 'OK'

    });

};

</script>

<?php

unset($_SESSION['contact_success']);

endif;

?>
<div class="container py-5">

<h1 class="mb-5 fw-bold">Contact Us</h1>

<div class="row g-4 align-items-stretch">

<!-- LEFT FORM -->
<div class="col-lg-7">

<div class="contact-card p-4 h-100">

<form method="POST" action="/evol/public/contact/store">

<div class="row g-3">

<!-- NAME -->
<div class="col-md-4">
<label>Name</label>
<input type="text" class="form-control"
value="<?= htmlspecialchars($user['name']) ?>" readonly>
</div>

<!-- USERNAME -->
<div class="col-md-4">
<label>Username</label>
<input type="text" class="form-control"
value="<?= htmlspecialchars($user['username']) ?>" readonly>
</div>

<!-- EMAIL -->
<div class="col-md-4">
<label>Email</label>
<input type="text" class="form-control"
value="<?= htmlspecialchars($user['email']) ?>" readonly>
</div>

<!-- SUBJECT -->
<div class="col-md-6">
<label>Subject</label>
<input type="text" name="subject" class="form-control" required>
</div>

<!-- PHONE -->
<div class="col-md-6">
<label>Phone</label>
<input type="text" name="phone" class="form-control">
</div>

<!-- MESSAGE -->
<div class="col-12">
<label>Message</label>
<textarea name="message" rows="4" class="form-control" required></textarea>
</div>

<!-- BUTTON -->
<div class="col-12 mt-3">
<button class="btn btn-dark px-4 py-2">
Send Message →
</button>
</div>

</div>

</form>

</div>

</div>


<!-- RIGHT IMAGE -->
<div class="col-lg-5">

<div class="contact-image h-100 d-flex flex-column justify-content-end">

<div class="overlay-text p-4">

<span class="badge bg-light text-dark mb-2">EvolBooks</span>

<h5 class="text-white">
We’ll respond within 24 hours 
</h5>

</div>

</div>

</div>

</div>

</div>