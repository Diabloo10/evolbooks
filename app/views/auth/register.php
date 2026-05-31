<div class="container-fluid d-flex justify-content-center align-items-center p-5">

<div class="col-lg-4 col-md-6 col-sm-8 col-10 border border-1 border-dark rounded-3 shadow my-5 py-5 mx-3 form-overlay">

<h1 class="text-center mb-3">Register</h1>

<p class="text-danger text-center">
<?php if(isset($error)) echo $error; ?>
</p>

<form method="POST" action="/evol/public/auth/register">

<div class="mb-3 px-3">
<label class="form-label text-dark">Name</label>

<input type="text"
class="form-control"
name="name"
placeholder="Enter your name"
required>
</div>

<div class="mb-3 px-3">
<label class="form-label text-dark">Email</label>

<input type="email"
class="form-control"
name="email"
placeholder="Enter your email"
required>
</div>

<div class="mb-3 px-3">
<label class="form-label text-dark">Username</label>

<input type="text"
class="form-control"
name="username"
placeholder="Enter username"
required>
</div>

<div class="mb-3 px-3">
<label class="form-label text-dark">Password</label>

<input type="password"
class="form-control"
name="password"
placeholder="Enter password"
required>
</div>

<div class="d-grid p-3">
<button type="submit" class="btn btn-primary">
Register
</button>
</div>

<a class="d-grid text-center mt-4"
href="/evol/public/auth/login">

Already have an account? Login

</a>

</form>

</div>

</div>