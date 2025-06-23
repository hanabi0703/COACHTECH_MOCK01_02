window.addEventListener('load', function main() {
    const tabItems = document.querySelectorAll(".tab__title");

    tabItems.forEach((tabItem) => {
        tabItem.addEventListener("click", () => {
            tabItems.forEach((t) => {
                t.classList.remove("active");
            });
            const tabPanels = document.querySelectorAll(".tab__panel");
            tabPanels.forEach((tabPanel) => {
                tabPanel.classList.remove("active");
            });
            tabItem.classList.add("active");
            const tabIndex = Array.from(tabItems).indexOf(tabItem);
            tabPanels[tabIndex].classList.add("active");
        });
    });
});