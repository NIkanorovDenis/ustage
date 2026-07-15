/**
 * Sticky Header scroll
 */

window.addEventListener('scroll', function() {
    const headerTop = document.querySelector('.header__top');
    const header = document.querySelector('.header');
    let offsetTop = 0;

    if (headerTop) {
        offsetTop = headerTop.clientHeight;
    }

    if (window.scrollY >= offsetTop) {
        header.style.top = `-${offsetTop}px`;
        header.classList.add('sticky')
    } else {
        header.classList.remove('sticky')
    }

    // скрывать всплывающий поиск при скролле страницы
    const fixedSearch = document.querySelectorAll('.title-search-result');
    fixedSearch.forEach(item => {
        item.style.display = "none";
    })
});
