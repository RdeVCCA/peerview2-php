let lastLoadedPage = 0;
let loading = false;

const loader = document.querySelector("#note-loader");

const observer = new IntersectionObserver(async (entries, observer) => {
    if (!entries[0].isIntersecting || loading) return;

    loading = true;
    lastLoadedPage++;

    const urlParams = new URLSearchParams();
    urlParams.append("pageNumber", lastLoadedPage);

    const response = await fetch(`/library?${urlParams}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    });

    const html = await response.text();
    if (html.trim() === "") {
        observer.disconnect();
        return;
    }

    document.querySelector("#note-entries").insertAdjacentHTML("beforeend", html)
    loading = false;
});

observer.observe(loader);
