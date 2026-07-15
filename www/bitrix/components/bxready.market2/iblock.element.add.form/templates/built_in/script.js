function getMaxHeightMobileForm() {

    const heightTopMenu = 97;
    const heightScreen = window.screen.height;
    let maxHeightMobileForm = heightScreen - heightTopMenu;

    return (maxHeightMobileForm < 0) ? 0 : maxHeightMobileForm;

}

function setAttributeScroll(element) {

    const maxHeightMobileForm = getMaxHeightMobileForm();
    const styleFormScroll = 'overflow: auto; max-height: ' + maxHeightMobileForm + 'px;';
    element.setAttribute('style', styleFormScroll);

}

window.addEventListener('load', () => {

    if (window.screen.width < 992) {
        const formContactsScroll = document.getElementById('bxr-mobile-contacts');
        const formPhoneScroll = document.getElementById('bxr-mobile-phone');
        const formMenuScroll = document.getElementById('bxr-multilevel-menu');

        setAttributeScroll(formContactsScroll);
        setAttributeScroll(formPhoneScroll);
        setAttributeScroll(formMenuScroll);
    }

});