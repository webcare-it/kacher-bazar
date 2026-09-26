// // Fixed navbar
// window.addEventListener("scroll", function () {
//     const scrollTop = window.scrollY; // Use window.scrollY to get the scroll position
//     const fixedNavbar = document.getElementById("fixed-navbar");

//     if (scrollTop >= 100) {
//       fixedNavbar.classList.remove("hidden");
//     } else {
//       fixedNavbar.classList.add("hidden");
//     }
//   });

document.addEventListener("DOMContentLoaded", function () {
    const decreaseBtn = document.querySelector(".quantity-btn:first-child");
    const increaseBtn = document.querySelector(".quantity-btn:last-child");
    const quantityDisplay = document.querySelector(".quantity-display");
    let inputQty = document.getElementById("inputQty");

    decreaseBtn.addEventListener("click", function () {
        let currentQuantity = parseInt(quantityDisplay.textContent);
        if (currentQuantity > 1) {
            currentQuantity--;
            quantityDisplay.textContent = currentQuantity;
            inputQty.value = currentQuantity;
        }
    });

    increaseBtn.addEventListener("click", function () {
        let currentQuantity = parseInt(quantityDisplay.textContent);
        if (10 > currentQuantity) {
            currentQuantity++;
            quantityDisplay.textContent = currentQuantity;
            inputQty.value = currentQuantity;
        }
    });
});

// details tab
// document.addEventListener("DOMContentLoaded", function () {
//     const tabButtons = document.querySelectorAll(".tab-btn");
//     const tabContents = document.querySelectorAll(".tab-content");

//     tabButtons.forEach((button) => {
//         button.addEventListener("click", function () {
//             const tabId = this.getAttribute("data-tab");

//             tabButtons.forEach((btn) => {
//                 btn.classList.remove(
//                     "bg-variableproduct",
//                     "text-primary",
//                     "active"
//                 );
//                 btn.classList.add("bg-light", "text-dark");
//             });
//             this.classList.remove("bg-light", "text-dark");
//             this.classList.add("bg-variableproduct", "text-primary", "active");

//             tabContents.forEach((content) => {
//                 content.style.display = "none";
//             });
//             document.getElementById(tabId + "Tab").style.display = "block";
//         });
//     });

//     document.getElementById("descriptionTab").style.display = "block";
// });

// const reviewTab = document.getElementById("reviewTab");
// fetch("/assets/data/reviews.json")
//     .then((res) => res.json())
//     .then((data) => {
//         data.forEach((r) => {
//             const div = document.createElement("div");
//             div.className =
//                 "bg-secondary p-2 lg:p-4 flex items-center gap-4 mx-auto mb-4 rounded-md";
//             div.innerHTML = `
//              <div>
//               <div class="flex items-center gap-2 ">
//               <img src=${r.userProfile} alt="" class="w-8 lg:w-12">
//                 <h4>${r.userName}</h4>
//                 <div>
//                 ${
//                     r.isVerified
//                         ? <p class="bg-primary px-2 py-1 rounded-md text-xs lg:text-lg">Verified</p>
//                         : ""
//                 }
//                 </div>
//               </div>
//               <div>
//                 <p>${r.review}</p>
//               </div>
//               <div class="product-rating h-12">
//                   <span class="fa fa-star ${
//                       r.rating >= 1 ? "checked " : ""
//                   }"></span>
//                   <span class="fa fa-star ${
//                       r.rating >= 2 ? "checked" : ""
//                   }"></span>
//                   <span class="fa fa-star ${
//                       r.rating >= 3 ? "checked" : ""
//                   }"></span>
//                   <span class="fa fa-star ${
//                       r.rating >= 4 ? "checked" : ""
//                   }"></span>
//                   <span class="fa fa-star ${
//                       r.rating == 5 ? "checked" : ""
//                   }"></span>
//                 </div>
//               </div>
//           `;

//             reviewTab.appendChild(div);
//         });
//     })
//     .catch((error) => {
//         console.error("Error fetching review data:", error.message);
//     });

let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
    showSlides((slideIndex += n));
}

function currentSlide(n) {
    showSlides((slideIndex = n));
}

function showSlides(n) {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("thumbnail");
    if (n > slides.length) {
        slideIndex = 1;
    }
    if (n < 1) {
        slideIndex = slides.length;
    }
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex - 1].style.display = "block";
    //   dots[slideIndex - 1].className += " active";
}

setInterval(() => {
    plusSlides(1);
}, 5000);

const buttons = document.querySelectorAll("#buttonGroup button");
buttons.forEach((button) => {
    button.addEventListener("click", function () {
        buttons.forEach((btn) => {
            btn.classList.remove("bg-variableproduct", "text-primary");
            btn.classList.add("bg-secondary");
        });

        this.classList.remove("bg-secondary");
        this.classList.add("bg-variableproduct", "text-primary");
    });
});

let size = true;
const sizeContainer = document.getElementById("size");
if (size) {
    sizeContainer.classList.remove("hidden");
} else {
    sizeContainer.classList.add("hidden");
}

// size button
const sizeButtons = document.querySelectorAll(".sizeButtonGroups button");
sizeButtons.forEach((button) => {
    button.addEventListener("click", function () {
        sizeButtons.forEach((btn) => {
            btn.classList.remove("bg-variableproduct", "text-primary");
            btn.classList.add("bg-secondary");
        });

        this.classList.remove("bg-secondary");
        this.classList.add("bg-variableproduct", "text-primary");
        console.log(this.textContent.trim());
    });
});

// size value
const price = document.getElementById("price");
let putSize = document.getElementById("inputsize");
let putPrice = document.getElementById("inputPrice");
function productSize(val, s) {
    price.innerText = val;
    putSize.value = s;
    putPrice.value = val;
}

let putColor = document.getElementById("inputcolor");
function ProductColor(color) {
    putColor.value = color;
}