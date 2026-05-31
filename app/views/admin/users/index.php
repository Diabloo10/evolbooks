<?php 
/** @var array $users */

?>

<div class="container py-5">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2 class="fw-bold">Manage Users</h2>

</div>

<div class="table-responsive">

<table class="table table-bordered table-hover align-middle">

<thead class="table-dark">

<tr>

<th>ID</th>
<th>Name</th>
<th>Username</th>
<th>Email</th>
<th>Role</th>
<th>Action</th>

</tr>

</thead>

<tbody>

<?php foreach($users as $user): ?>

<tr>

<td><?= $user['id'] ?></td>

<td><?= htmlspecialchars($user['name']) ?></td>

<td><?= htmlspecialchars($user['username']) ?></td>

<td><?= htmlspecialchars($user['email']) ?></td>

<td>

<?php if($user['role'] == 'admin'): ?>

<span class="badge bg-success">
Admin
</span>

<?php else: ?>

<span class="badge bg-secondary">
User
</span>

<?php endif; ?>

</td>

<td>

<?php if($user['role'] != 'admin'): ?>

<a href="/evol/public/adminUser/delete/<?= $user['id'] ?>"
class="btn btn-sm btn-danger"
onclick="return confirm('Delete this user?')">

Delete

</a>

<?php else: ?>

<button class="btn btn-sm btn-dark" disabled>
Protected
</button>

<?php endif; ?>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

</div>