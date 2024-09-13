const zxHeader = document.getElementById('zxHeader');
const zxHamburgerMenu = document.getElementById('zxHamburgerMenu');
const zxNavbar = document.getElementById('zxNavbar');

zxHamburgerMenu.onclick = () => {
    zxHeader.classList.toggle("zxSliders");
}

document.addEventListener("click", (e) => {
    if (!zxHamburgerMenu.contains(e.target) && !zxNavbar.contains(e.target)) {
        zxHeader.classList.remove("zxSliders");
    }
});

const ZXLinks = document.querySelectorAll("#ZXLink");
ZXLinks.forEach((ZXLink) => {
    ZXLink.addEventListener("click", (e) => {
        zxHeader.classList.remove("zxSliders");
    });
});
