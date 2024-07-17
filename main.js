const menu = document.querySelector(".nav__menu");
const menuBtn = document.querySelector("#open-menu-btn");
const closeBtn = document.querySelector("#close-menu-btn");

menuBtn.addEventListener("click", () => {
  menu.style.display = "block";
  menu.style.left = "0";
  closeBtn.style.display = "inline-block";
  menuBtn.style.display = "none";
});

const closeNav = () => {
  menu.style.display = "none";
  closeBtn.style.display = "none";
  menuBtn.style.display = "inline-block";
};

closeBtn.addEventListener("click", closeNav);

const videoThumbnails = document.querySelectorAll(
  ".video-gallery .all-videos .thumbnail"
);

const videoPlayer = document.querySelector(
  ".video-gallery .featured-video iframe"
);

const videoTitle = document.querySelector(".video-gallery .video-title");

const showVideo = (videoId, title) => {
  let videoUrl = `https://www.youtube.com/embed/${videoId}?rel=0`;
  videoPlayer.setAttribute("src", videoUrl);
  videoTitle.innerHTML = title;
};
videoThumbnails.forEach((v) => {
  v.addEventListener("click", () => {
    showVideo(v.dataset.id, v.dataset.title);
  });
});

let questionClick = document.querySelectorAll(".questionClick");
questionClick.forEach((e) => {
  e.addEventListener("click", () => {
    let para = e.parentNode.childNodes[3];
    para.classList.toggle("collapsed");
  });
});

window.onscroll = function () {
  myFunction();
};
var header = document.getElementsByClassName("header")[0];
function myFunction() {
  if (pageYOffset > 150) {
    header.classList.add("sticky-bar");
  } else {
    header.classList.remove("sticky-bar");
  }
}