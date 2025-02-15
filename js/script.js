const left = document.querySelector(".left");
const right = document.querySelector(".right");
const slider = document.querySelector(".slider");

const images = document.querySelectorAll(".image");
let slideNumber = 1;

right.addEventListener("click", () => {
  if (slideNumber < images.length) {
    slider.style.transform = `translateX(-${slideNumber * 800}px)`;
    slideNumber++;
  } else {
    slider.style.transform = `translateX(0px)`;
    slideNumber = 1;
  }
});
