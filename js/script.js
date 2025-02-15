// Select elements with classes ".left", ".right", and ".slider"
const left = document.querySelector(".left");
const right = document.querySelector(".right");
const slider = document.querySelector(".slider");

// Select all image elements
const images = document.querySelectorAll(".image");

// Variable to track the current slide number
let slideNumber = 1;

// Get the total number of images
const length = images.length;

// Function to move to the next slide
const nextSlide = () => {
  // Move the slider to the left by 800px per slide
  slider.style.transform = `translateX(-${slideNumber * 800}px)`;
  // Increment the slide number
  slideNumber++;
};

// Function to move to the previous slide
const prevSlide = () => {
  // Move the slider to the right by 800px per slide
  slider.style.transform = `translateX(-${(slideNumber - 2) * 800}px)`;
  // Decrement the slide number
  slideNumber--;
};

// Function to go to the first slide
const getFirstSlide = () => {
  // Reset the slider position to the first slide
  slider.style.transform = `translateX(0px)`;
  // Set slide number to 1
  slideNumber = 1;
};

// Function to go to the last slide
const getLastSlide = () => {
  // Move the slider to the last image
  slider.style.transform = `translateX(-${(length - 1) * 800}px)`;
  // Set slide number to the last slide
  slideNumber = length;
};

// Event listener for the right (→) button click
// Moves to the next slide, or goes back to the first slide if at the last slide
right.addEventListener("click", () => {
  slideNumber < length ? nextSlide() : getFirstSlide();
});

// Event listener for the left (←) button click
// Moves to the previous slide, or goes to the last slide if at the first slide
left.addEventListener("click", () => {
  slideNumber > 1 ? prevSlide() : getLastSlide();
});
