<?php
/** @var array $contacts */
?>

<div class="contacts-page container-fluid py-5">

<!-- HEADER -->

<div class="contacts-header">

<div>

<h1 class="contacts-title">
📩 Contact Management
</h1>

<p class="contacts-subtitle">
Manage user inquiries and messages professionally
</p>

</div>


<div class="contacts-stats">

<div class="mini-stat">

<h4>
<?= count($contacts) ?>
</h4>

<p>Messages</p>

</div>

</div>

</div>


<!-- TOP CONTROLS -->

<div class="top-controls">

<input
type="text"
id="contactSearch"
class="contact-search"
placeholder="🔍 Search by name, email or message...">


<select id="messageFilter" class="message-filter">

<option value="all">All Messages</option>
<option value="short">Short Messages</option>
<option value="long">Long Messages</option>

</select>

</div>


<!-- CONTACTS GRID -->

<div class="row g-4" id="contactsContainer">

<?php foreach($contacts as $contact): ?>

<div class="col-xl-4 col-lg-6 contact-item">

<div class="contact-card">

<!-- TOP -->

<div class="contact-top">

<div class="contact-user">

<div class="contact-avatar">

<?= strtoupper(substr($contact['name'],0,1)) ?>

</div>

<div>

<h5 class="contact-name">

<?= htmlspecialchars($contact['name']) ?>

</h5>

<p class="contact-email">

<?= htmlspecialchars($contact['email']) ?>

</p>

</div>

</div>


<div class="message-badge">

📨 Message

</div>

</div>


<!-- MESSAGE -->

<div class="message-area">

<p class="message-text">

<?= nl2br(htmlspecialchars($contact['message'])) ?>

</p>

</div>


<!-- FOOTER -->

<div class="contact-footer">

<div class="message-time">

🕒
<?= date('d M Y', strtotime($contact['created_at'])) ?>

</div>


<div class="footer-actions">

<!-- VIEW -->

<button
class="action-btn view-btn"

data-bs-toggle="modal"
data-bs-target="#messageModal<?= $contact['id'] ?>">

View

</button>


<!-- DELETE -->

<a
href="/evol/public/admincontact/delete/<?= $contact['id'] ?>"
class="action-btn delete-btn"

onclick="return confirm('Delete this message?')">

Delete

</a>

</div>

</div>

</div>

</div>


<!-- MODAL -->

<div
class="modal fade"
id="messageModal<?= $contact['id'] ?>"
tabindex="-1">

<div class="modal-dialog modal-dialog-centered">

<div class="modal-content custom-modal">

<div class="modal-header border-0">

<h5 class="modal-title">

📩 Message Details

</h5>

<button
type="button"
class="btn-close"
data-bs-dismiss="modal">

</button>

</div>


<div class="modal-body">

<div class="modal-user-info mb-4">

<div class="contact-avatar large-avatar">

<?= strtoupper(substr($contact['name'],0,1)) ?>

</div>

<div>

<h5 class="mb-1">

<?= htmlspecialchars($contact['name']) ?>

</h5>

<p class="text-muted mb-0">

<?= htmlspecialchars($contact['email']) ?>

</p>

</div>

</div>


<div class="full-message-box">

<?= nl2br(htmlspecialchars($contact['message'])) ?>

</div>

</div>


<div class="modal-footer border-0">

<a
href="mailto:<?= htmlspecialchars($contact['email']) ?>"
class="reply-btn">

✉ Reply

</a>

</div>

</div>

</div>

</div>

<?php endforeach; ?>

</div>

</div>


<script>

/* =========================
   SEARCH
========================= */

const searchInput =
document.getElementById('contactSearch');

searchInput.addEventListener('keyup', function(){

    filterMessages();

});


/* =========================
   FILTER
========================= */

const messageFilter =
document.getElementById('messageFilter');

messageFilter.addEventListener('change', function(){

    filterMessages();

});


/* =========================
   FILTER FUNCTION
========================= */

function filterMessages(){

    let searchValue =
    searchInput.value.toLowerCase();

    let filterValue =
    messageFilter.value;

    let cards =
    document.querySelectorAll('.contact-item');

    cards.forEach(card => {

        let name =
        card.querySelector('.contact-name')
        .innerText
        .toLowerCase();

        let email =
        card.querySelector('.contact-email')
        .innerText
        .toLowerCase();

        let message =
        card.querySelector('.message-text')
        .innerText
        .toLowerCase();

        let matchesSearch =
        name.includes(searchValue)
        ||
        email.includes(searchValue)
        ||
        message.includes(searchValue);

        let matchesFilter = true;

        if(filterValue === 'short'){
            matchesFilter = message.length < 120;
        }

        if(filterValue === 'long'){
            matchesFilter = message.length >= 120;
        }

        if(matchesSearch && matchesFilter){
            card.style.display = '';
        }
        else{
            card.style.display = 'none';
        }

    });

}

</script>