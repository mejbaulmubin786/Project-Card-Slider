// Selecting required elements
const left = document.querySelector(".left"); // Left arrow button
const right = document.querySelector(".right"); // Right arrow button
const slider = document.querySelector(".slider"); // Image slider container

const images = document.querySelectorAll(".image"); // Selecting all images in the slider
let slideNumber = 1; // Initial slide number

const length = images.length; // Total number of images in the slider

// Creating navigation buttons dynamically
const bottom = document.querySelector(".bottom");
for (let i = 0; i < length; i++) {
  const div = document.createElement("div"); // Creating a new div for each button
  div.className = "button"; // Assigning a class name to the button
  bottom.appendChild(div); // Appending the button to the bottom navigation
}

const buttons = document.querySelectorAll(".button"); // Selecting all buttons
buttons[0].style.backgroundColor = "white"; // Highlighting the first button by default

// Function to reset the background color of all buttons
const resetBg = () => {
  buttons.forEach((button) => {
    button.style.backgroundColor = "transparent";
    button.addEventListener("mouseover", stopSlideShow);
    button.addEventListener("mouseout", startSlideShow);
  });
};

// Adding click event to each button for manual slide navigation
buttons.forEach((button, i) => {
  button.addEventListener("click", () => {
    resetBg(); // Reset previous button colors
    slider.style.transform = `translateX(-${i * 800}px)`; // Move the slider
    slideNumber = i + 1; // Update slide number
    button.style.backgroundColor = "white"; // Highlight active button
  });
});

// Function to change the color of the navigation button based on the current slide
const changeColor = () => {
  resetBg();
  buttons[slideNumber - 1].style.backgroundColor = "white";
};

// Function to move to the next slide
const nextSlide = () => {
  slider.style.transform = `translateX(-${slideNumber * 800}px)`;
  slideNumber++;
};

// Function to move to the previous slide
const prevSlide = () => {
  slider.style.transform = `translateX(-${(slideNumber - 2) * 800}px)`;
  slideNumber--;
};

// Function to go back to the first slide
const getFirstSlide = () => {
  slider.style.transform = `translateX(0px)`;
  slideNumber = 1;
};

// Function to go to the last slide
const getLastSlide = () => {
  slider.style.transform = `translateX(-${(length - 1) * 800}px)`;
  slideNumber = length;
};

// Adding click event to right button for moving forward
right.addEventListener("click", () => {
  slideNumber < length ? nextSlide() : getFirstSlide(); // Loop back to first slide if at the end
  changeColor();
});

// Adding click event to left button for moving backward
left.addEventListener("click", () => {
  slideNumber > 1 ? prevSlide() : getLastSlide(); // Loop back to last slide if at the beginning
  changeColor();
});

// Auto slide functionality
let slideInterval;

// Function to start automatic slideshow
const startSlideShow = () => {
  slideInterval = setInterval(() => {
    slideNumber < length ? nextSlide() : getFirstSlide();
    changeColor();
  }, 2000); // Slide changes every 2 seconds
};

// Function to stop automatic slideshow
const stopSlideShow = () => {
  clearInterval(slideInterval);
};

// Start the slideshow automatically when the page loads
startSlideShow();

// Pause slideshow when hovering over elements and resume when mouse leaves
slider.addEventListener("mouseover", stopSlideShow);
slider.addEventListener("mouseout", startSlideShow);
right.addEventListener("mouseover", stopSlideShow);
right.addEventListener("mouseout", startSlideShow);
left.addEventListener("mouseover", stopSlideShow);
left.addEventListener("mouseout", startSlideShow);
