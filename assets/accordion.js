
    const accordionHeader = document.querySelectorAll(".accordion-header");
    accordionHeader.forEach((header) => {
    header.addEventListener("click", function () {
        const accordionContent = header.parentElement.querySelector(".accordion-content");
        let accordionMaxHeight = accordionContent.style.maxHeight;

        // Condition handling
        if (accordionMaxHeight == "0px" || accordionMaxHeight.length == 0) {
            header.querySelector(".down").classList.add("hidden");
            header.querySelector(".up").classList.remove("hidden");
            accordionContent.style.maxHeight = `${accordionContent.scrollHeight + 32}px`;
            header.parentElement.classList.add("bg-indigo-50");
        } else {
            header.querySelector(".up").classList.add("hidden");
            header.querySelector(".down").classList.remove("hidden");
            accordionContent.style.maxHeight = `0px`;
            header.parentElement.classList.remove("bg-indigo-50");
        }
    });
});
