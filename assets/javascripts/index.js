alert("This is a test version of PeerView and has no functionality.\nPlease go to peerview.x10.mx to use PeerView.");

// note preview section
const topButton = document.querySelector("#top-notes-button");
const newestButton = document.querySelector("#newest-notes-button");
const topNotes = document.querySelector("#top-notes");
const newestNotes = document.querySelector("#newest-notes");

function onClick() {
    topButton.classList.toggle("selected");
    newestButton.classList.toggle("selected");
    topNotes.classList.toggle("hidden");
    newestNotes.classList.toggle("hidden");
}

topButton.addEventListener("click", e => {
    if (!topButton.classList.contains("selected")) {
        onClick();
    }
});

newestButton.addEventListener("click", e => {
    if (!newestButton.classList.contains("selected")) {
        onClick();
    }
});