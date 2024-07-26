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

let materials_btn = document.querySelectorAll(".materials-pay-btn");
let facebook_btn = document.querySelectorAll(".facebook-pay-btn");

let Paymentmodalfunction = (btn) => {
  btn.forEach((e) => {
    e.addEventListener("click", () => {
      payment_popup = e.parentNode.parentNode.parentNode.childNodes[5];
      closebtn = e.parentNode.parentNode.parentNode.childNodes[5];
      closebtn =
        closebtn.childNodes[1].childNodes[1].childNodes[1].childNodes[1];
      payment_popup.style.display = "block";
      closebtn.onclick = function () {
        payment_popup.style.display = "none";
      };

      window.onclick = function (event) {
        if (event.target == payment_popup) {
          payment_popup.style.display = "none";
        }
      };

      copynumberBtn =
        payment_popup.childNodes[1].childNodes[3].childNodes[3].childNodes[1]
          .childNodes[0].childNodes[5].childNodes[0];

      copyIdBtn =
        payment_popup.childNodes[1].childNodes[3].childNodes[3].childNodes[1]
          .childNodes[2].childNodes[5].childNodes[0];

      copynumberBtn.onclick = () => {
        Bkash_number =
          payment_popup.childNodes[1].childNodes[3].childNodes[3].childNodes[1]
            .childNodes[0].childNodes[3].childNodes[0];
        Bkash_number.select();
        Bkash_number.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(Bkash_number.value);
        copynumberBtn.innerHTML = "Copied";
      };

      copyIdBtn.onclick = () => {
        ref_id_number =
          payment_popup.childNodes[1].childNodes[3].childNodes[3].childNodes[1]
            .childNodes[2].childNodes[3].childNodes[0];
        ref_id_number.select();
        ref_id_number.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(ref_id_number.value);
        copyIdBtn.innerHTML = "Copied";
      };
    });
  });
};

Paymentmodalfunction(facebook_btn);
Paymentmodalfunction(materials_btn);

let inputPassShow = document.getElementById("password_view_img");
let inputpass = document.getElementById("password");

inputPassShow.addEventListener("click", () => {
  const type =
    inputpass.getAttribute("type") === "password" ? "text" : "password";
    inputpass.setAttribute("type", type);
});
