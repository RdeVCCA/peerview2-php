// autoload new notes
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
        loader.classList.add("finished");
        return;
    }

    document.querySelector("#note-entries").insertAdjacentHTML("beforeend", html)
    hookExpanderButtonsToViews();
    loading = false;
});

observer.observe(loader);

function hookExpanderButtonsToViews() {
    // connects expander button's click event to the class toggle
    const noteEntries = document.querySelectorAll("#library .note-entry");
    for (const entry of noteEntries) {
        const expander = entry.querySelector(".expander");
        if (expander.hasAttribute("listening")) {
            // skip already connected expanders
            continue;
        }

        expander.setAttribute("listening", "true");
        expander.addEventListener("click", function () {
            entry.classList.toggle("collapsed");
        });
    }
}

hookExpanderButtonsToViews();
