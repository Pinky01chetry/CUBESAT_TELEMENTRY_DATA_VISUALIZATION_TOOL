// Smooth fade-in for hero section
window.addEventListener("DOMContentLoaded", () => {
    const hero = document.querySelector(".hero");
    hero.style.opacity = 0;
    hero.style.transition = "opacity 1.5s ease-in-out";
    setTimeout(() => {
        hero.style.opacity = 1;
    }, 200);
});

// Smooth scroll for nav links
document.querySelectorAll('.navbar a').forEach(link => {
    link.addEventListener("click", function (e) {
        // Only if you're linking to an anchor
        if (this.getAttribute("href").startsWith("#")) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute("href"));
            target.scrollIntoView({ behavior: "smooth" });
        }
    });
});
