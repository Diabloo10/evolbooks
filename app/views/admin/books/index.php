<?php 
/** @var array $books */
?>

<div class="manage-books-page">

    <!-- PAGE HEADER -->

    <div class="books-top-header">

        <div>

            <h1 class="books-page-title">
                 Manage Books
            </h1>

            <p class="books-page-subtitle">
                Professional book management dashboard
            </p>

        </div>

        <a href="/evol/public/adminbook/create"
           class="add-book-btn">

             Add New Book

        </a>

    </div>


    <!-- SEARCH + FILTER -->

    <div class="books-controls">

        <input
            type="text"
            id="bookSearch"
            class="book-search-input"
            placeholder="🔍 Search books by title, author or genre...">

    </div>


    <!-- TABLE CARD -->

    <div class="books-table-card">

        <div class="table-responsive">

            <table class="table books-table align-middle">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Book</th>
                        <th>Author</th>
                        <th>ISBN</th>
                        <th>Language</th>
                        <th>Genres</th>
                        <th>Description</th>
                        <th>PDF</th>
                        <th>Actions</th>

                    </tr>

                </thead>

                <tbody id="booksTable">

                <?php foreach($books as $book): ?>

                    <tr class="book-row">

                        <!-- ID -->

                        <td>

                            <span class="book-id">

                                #<?= $book['id'] ?>

                            </span>

                        </td>


                        <!-- BOOK -->

                        <td>

                            <div class="book-info">

                                <?php if(!empty($book['cover_image'])): ?>

                                    <img
                                        src="/evol/storage/uploads/<?= $book['cover_image'] ?>"
                                        class="book-cover-img">

                                <?php endif; ?>

                                <div>

                                    <h6 class="book-title">

                                        <?= htmlspecialchars($book['title']) ?>

                                    </h6>

                                    <p class="book-subtitle">

                                        Digital Library Book

                                    </p>

                                </div>

                            </div>

                        </td>


                        <!-- AUTHOR -->

                        <td class="book-author">

                            <?= htmlspecialchars($book['author']) ?>

                        </td>


                        <!-- ISBN -->

                        <td>

                            <span class="isbn-badge">

                                <?= htmlspecialchars($book['isbn']) ?>

                            </span>

                        </td>


                        <!-- LANGUAGE -->

                        <td>

                            <span class="language-badge">

                                <?= htmlspecialchars($book['language']) ?>

                            </span>

                        </td>


                        <!-- GENRES -->

                        <td>

                            <?php
                            $genres = explode(',', $book['genres']);
                            ?>

                            <div class="genre-wrapper">

                                <?php foreach($genres as $genre): ?>

                                    <span class="genre-badge">

                                        <?= trim($genre) ?>

                                    </span>

                                <?php endforeach; ?>

                            </div>

                        </td>


                        <!-- DESCRIPTION -->

                        <td>

                            <div class="description-box">

                                <?= htmlspecialchars(substr($book['description'],0,120)) ?>...

                            </div>

                        </td>


                        <!-- PDF -->

                        <td>

                            <?php if(!empty($book['pdf_file'])): ?>

                                <a
                                    href="/evol/storage/books/<?= $book['pdf_file'] ?>"
                                    target="_blank"
                                    class="pdf-btn">

                                     View

                                </a>

                            <?php endif; ?>

                        </td>


                        <!-- ACTIONS -->

                        <td>

                            <div class="action-buttons">

                                <!-- EDIT -->

                                <a
                                    href="/evol/public/adminbook/edit/<?= $book['id'] ?>"
                                    class="edit-btn">

                                     Edit

                                </a>


                                <!-- DELETE -->

                                <a
                                    href="/evol/public/adminbook/delete/<?= $book['id'] ?>"
                                    class="delete-btn"

                                    onclick="return confirm('Are you sure you want to delete this book?')">

                                     Delete

                                </a>

                            </div>

                        </td>

                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>



<script>

/* =========================================
   SEARCH FILTER
========================================= */

const bookSearch =
document.getElementById('bookSearch');

bookSearch.addEventListener('keyup', function(){

    let value =
    this.value.toLowerCase();

    let rows =
    document.querySelectorAll('.book-row');

    rows.forEach(row => {

        let text =
        row.innerText.toLowerCase();

        if(text.includes(value)){

            row.style.display = '';

        }
        else{

            row.style.display = 'none';

        }

    });

});

</script>