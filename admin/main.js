let inputPassShow = document.getElementById("password_view_img");
let inputpass = document.getElementById("password");

inputPassShow.addEventListener("click", () => {
  const type =
    inputpass.getAttribute("type") === "password" ? "text" : "password";
    inputpass.setAttribute("type", type);
});