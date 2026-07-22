<script>
window.ustageLoadOptionalCookies = window.ustageLoadOptionalCookies || function () {
    if (window.ustageOptionalCookiesLoaded) {
        return;
    }

    window.ustageOptionalCookiesLoaded = true;

    (function (m, e, t, r, i, k, a) {
        m[i] = m[i] || function () { (m[i].a = m[i].a || []).push(arguments); };
        m[i].l = 1 * new Date();
        k = e.createElement(t);
        a = e.getElementsByTagName(t)[0];
        k.async = true;
        k.src = r;
        a.parentNode.insertBefore(k, a);
    })(window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    window.ym(80012047, "init", {
        clickmap: true,
        trackLinks: true,
        accurateTrackBounce: true,
        webvisor: true,
        ecommerce: "dataLayer"
    });
    window.ym(80012047, "reachGoal", "popup");

    (function (w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({"gtm.start": new Date().getTime(), event: "gtm.js"});
        var firstScript = d.getElementsByTagName(s)[0];
        var tagManagerScript = d.createElement(s);
        var dataLayer = l !== "dataLayer" ? "&l=" + l : "";
        tagManagerScript.async = true;
        tagManagerScript.src = "https://www.googletagmanager.com/gtm.js?id=" + i + dataLayer;
        firstScript.parentNode.insertBefore(tagManagerScript, firstScript);
    })(window, document, "script", "dataLayer", "GTM-5W5DNWW4");

    (function (w, d, url) {
        var script = d.createElement("script");
        script.async = true;
        script.src = url + "?" + (Date.now() / 60000 | 0);
        var firstScript = d.getElementsByTagName("script")[0];
        firstScript.parentNode.insertBefore(script, firstScript);
    })(window, document, "https://b24.ustage-group.ru/upload/crm/site_button/loader_1_sttua1.js");

    (window.b24order = window.b24order || []).push({id: "КОДЗАКАЗА", sum: "СУММАЗАКАЗА"});
};
</script>
