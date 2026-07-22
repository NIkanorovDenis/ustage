/**
 * Sticky Header scroll
 */

const updateStickyHeader = function() {
    const headerTop = document.querySelector('.header__top');
    const header = document.querySelector('.header');
    let offsetTop = 0;

    if (!header) {
        return;
    }

    if (headerTop) {
        offsetTop = headerTop.clientHeight;
    }

    // The sticky state changes the header height (the logo gets smaller).
    // Do not remove it around the same threshold, otherwise scroll anchoring
    // can repeatedly move scrollY across that threshold and make it flicker.
    if (!header.classList.contains('sticky') && window.scrollY >= offsetTop) {
        header.style.top = `-${offsetTop}px`;
        header.classList.add('sticky');
    } else if (header.classList.contains('sticky') && window.scrollY <= 1) {
        header.classList.remove('sticky');
        header.style.top = '';
    }

    // скрывать всплывающий поиск при скролле страницы
    const fixedSearch = document.querySelectorAll('.title-search-result');
    fixedSearch.forEach(item => {
        item.style.display = "none";
    })
};

let stickyHeaderTicking = false;

window.addEventListener('scroll', function() {
    if (stickyHeaderTicking) {
        return;
    }

    stickyHeaderTicking = true;
    window.requestAnimationFrame(function() {
        updateStickyHeader();
        stickyHeaderTicking = false;
    });
}, { passive: true });

updateStickyHeader();
