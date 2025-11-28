
document.querySelector(".logBtn").addEventListener("click", function () {
    document.getElementById("logMod").style.display = "flex";
});

document.querySelector(".regBtn").addEventListener("click", function () {
    document.getElementById("regMod").style.display = "flex";
});

document.querySelectorAll(".close").forEach(function(btn) {
    btn.addEventListener("click", function () {
        this.parentElement.parentElement.style.display = "none";
    });
});
