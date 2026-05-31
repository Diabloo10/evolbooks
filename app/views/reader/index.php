<?php /** @var array $book */ ?>

<link rel="stylesheet"
href="/evol/public/assets/css/reader.css">

<div class="reader-container">

    <!-- TOP BAR -->

    <div class="reader-topbar">

        <div class="reader-book-info">

            <div class="book-mini-cover">

                <img
                src="/evol/storage/uploads/<?= htmlspecialchars($book['cover_image']) ?>">

            </div>

            <div>

                <h2>
                    <?= htmlspecialchars($book['title']) ?>
                </h2>

                <p>
                    by <?= htmlspecialchars($book['author']) ?>
                </p>

            </div>

        </div>


        <!-- CONTROLS -->

        <div class="reader-controls">

            <button id="zoomInBtn" class="reader-btn">
                ＋
            </button>

            <button id="zoomOutBtn" class="reader-btn">
                －
            </button>

            <button id="fullscreenBtn" class="reader-btn green-btn">
                ⛶ Fullscreen
            </button>

        </div>

    </div>


    <!-- READER STAGE -->

    <div class="reader-stage">

        <!-- LEFT NAV -->

        <button id="prevPage"
        class="nav-btn left-btn">

            ❮

        </button>


        <!-- FLIPBOOK -->

        <div class="flipbook-wrapper">

            <div id="flipbook"></div>

        </div>


        <!-- RIGHT NAV -->

        <button id="nextPage"
        class="nav-btn right-btn">

            ❯

        </button>

    </div>


    <!-- BOTTOM BAR -->

    <div class="reader-footer">

        <div id="pageNumber">
            Page 1
        </div>

        <div class="reading-badge">
            Secure Reader Mode
        </div>

    </div>

</div>



<!-- PDF JS -->

<script src="/evol/public/assets/pdfjs/pdf.min.js"></script>

<script src="/evol/public/assets/pageflip/page-flip.browser.js"></script>


<script>

pdfjsLib.GlobalWorkerOptions.workerSrc =
'/evol/public/assets/pdfjs/pdf.worker.min.js';

const pdfUrl =
"/evol/storage/books/<?= urlencode($book['pdf_file']) ?>";

const flipbook =
document.getElementById("flipbook");

let pageFlip;

let currentScale = 2.2;


/* =========================
   RENDER PDF
========================= */

async function renderPDF(){

    const pdf =
    await pdfjsLib.getDocument(pdfUrl).promise;

    for(let pageNum = 1; pageNum <= pdf.numPages; pageNum++){

        const page =
        await pdf.getPage(pageNum);

        const viewport =
        page.getViewport({
            scale: currentScale
        });

        const canvas =
        document.createElement("canvas");

        const context =
        canvas.getContext("2d");

        canvas.width = viewport.width;
        canvas.height = viewport.height;

        await page.render({
            canvasContext: context,
            viewport: viewport
        }).promise;

        const pageDiv =
        document.createElement("div");

        pageDiv.className = "page";

        const img =
        document.createElement("img");

        img.src =
        canvas.toDataURL();

        pageDiv.appendChild(img);

        flipbook.appendChild(pageDiv);
    }


    const isMobile =
window.innerWidth < 768;

const pageFlip =
new St.PageFlip(flipbook, {

    width: isMobile ? 320 : 700,

    height: isMobile ? 480 : 950,

    size: "stretch",

    minWidth: 280,
    maxWidth: 1800,

    minHeight: 400,
    maxHeight: 2400,

    drawShadow: true,

    flippingTime: 1000,

    usePortrait: true,

    startZIndex: 10,

    autoSize: true,

    mobileScrollSupport: true,

    showCover: true,

    maxShadowOpacity: 0.6,

    useMouseEvents: true
});

    pageFlip.loadFromHTML(
        document.querySelectorAll(".page")
    );

    

    /* PAGE CHANGE */

    pageFlip.on("flip", (e) => {

        document.getElementById("pageNumber")
        .innerText =
        "Page " + (e.data + 1);

    });

}

renderPDF();



/* =========================
   NAVIGATION
========================= */

document.getElementById("nextPage")
.addEventListener("click", () => {

    pageFlip.flipNext();

});

document.getElementById("prevPage")
.addEventListener("click", () => {

    pageFlip.flipPrev();

});


/* =========================
   FULLSCREEN
========================= */

document.getElementById("fullscreenBtn")
.addEventListener("click", () => {

    if(!document.fullscreenElement){

        document.documentElement
        .requestFullscreen();

    }
    else{

        document.exitFullscreen();

    }

});


/* =========================
   ZOOM
========================= */

let zoomLevel = 1;

const wrapper =
document.querySelector(".flipbook-wrapper");


document.getElementById("zoomInBtn")
.addEventListener("click", () => {

    zoomLevel += 0.1;

    if(zoomLevel > 3){
        zoomLevel = 3;
    }

    wrapper.style.transform =
    `scale(${zoomLevel})`;

});


document.getElementById("zoomOutBtn")
.addEventListener("click", () => {

    zoomLevel -= 0.1;

    if(zoomLevel < 0.6){
        zoomLevel = 0.6;
    }

    wrapper.style.transform =
    `scale(${zoomLevel})`;

});


/* =========================
   DISABLE RIGHT CLICK
========================= */

document.addEventListener("contextmenu", e => {
    e.preventDefault();
});

</script>