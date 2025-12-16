const drawnBy = document.querySelector("#drawn-by");
document.querySelectorAll(".pixel").forEach(pixel => {
    pixel.addEventListener("click", e => {
        const painter = e.target.dataset.user;
        drawnBy.textContent =
            painter === undefined
            ? "Nobody drew on this pixel before"
            : `This pixel was drawn by ${painter}`;
    });
})