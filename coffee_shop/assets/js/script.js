// ===========================
// COFFEE SHOP JS
// ===========================

console.log("Coffee Shop Loaded Successfully");


// ===========================
// MENU FILTER
// ===========================

const filterBtns =
    document.querySelectorAll(".filter-btn");

const menuCards =
    document.querySelectorAll(".menu-card");

filterBtns.forEach(btn => {

    btn.addEventListener("click", () => {

        document
            .querySelectorAll(".filter-btn")
            .forEach(b => b.classList.remove("active"));

        btn.classList.add("active");

        const filter =
            btn.dataset.filter;

        menuCards.forEach(card => {

            const category =
                card.dataset.category;

            if (
                filter === "all" ||
                category === filter
            ) {

                card.style.display = "block";

            } else {

                card.style.display = "none";

            }

        });

    });

});


// ===========================
// SHOP BY CATEGORY
// ===========================

function filterCategory(category){

    const cards =
        document.querySelectorAll(".menu-card");

    const buttons =
        document.querySelectorAll(".filter-btn");

    buttons.forEach(btn => {

        btn.classList.remove("active");

        if(btn.dataset.filter === category){

            btn.classList.add("active");

        }

    });

    cards.forEach(card => {

        if(
            card.dataset.category === category
        ){

            card.style.display = "block";

        }else{

            card.style.display = "none";

        }

    });

}


// ===========================
// DARK MODE
// ===========================

const toggleBtn =
    document.getElementById("theme-toggle");

// تحديث الأيقونة حسب الوضع الحالي
function updateIcon(){
    if(!toggleBtn) return;
    const icon = toggleBtn.querySelector('i');
    if(!icon) return;
    if(document.body.classList.contains('dark-mode')){
        icon.className = 'bi bi-sun-fill';
    } else {
        icon.className = 'bi bi-moon-fill';
    }
}

// تحميل الوضع المحفوظ عند فتح الصفحة
if(localStorage.getItem("theme") === "dark"){
    document.body.classList.add("dark-mode");
}

updateIcon();

if(toggleBtn){

    toggleBtn.addEventListener("click", () => {

        document.body.classList.toggle("dark-mode");

        if(document.body.classList.contains("dark-mode")){
            localStorage.setItem("theme", "dark");
        } else {
            localStorage.setItem("theme", "light");
        }

        updateIcon();

    });

}


// ===========================
// ABOUT US - OUR STORY
// ===========================

const storyBtn =
    document.getElementById("storyBtn");

const storyContent =
    document.getElementById("ourStoryContent");

if(storyBtn && storyContent){

    storyBtn.addEventListener("click", () => {

        storyContent.classList.toggle("show");

    });

}


// ===========================
// FEATURED PICKS SLIDER
// ===========================

let index = 0;
const slides = document.querySelectorAll('.slide');

function fadeSlider() {
    if(slides.length === 0) return;
    slides.forEach(slide => slide.classList.remove('active'));
    slides[index].classList.add('active');
    index = (index + 1) % slides.length;
}

if(slides.length > 0){
    fadeSlider();
    setInterval(fadeSlider, 3500);
}



// ===========================
// CHECKOUT SUCCESS POPUP
// ===========================

document.addEventListener("DOMContentLoaded", () => {

    const params = new URLSearchParams(window.location.search);

    if (params.get("success") === "1") {

        const popup = document.getElementById("successPopup");

        if (popup) {
            popup.classList.add("show-popup");

            let count = 5;
            const timer = setInterval(() => {
                count--;
                document.getElementById("countdown").textContent = count;

                if (count <= 0) {
                    clearInterval(timer);
                    window.location.href = "orders.php";
                }
            }, 1000);
        }
    }
});
