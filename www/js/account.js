document.addEventListener("DOMContentLoaded", function () {

    // =========================
    // СЛАЙДЕР
    // =========================

    var avatars = [
        "../img/logo1.png",
        "../img/logo2.png",
        "../img/logo3.png",
        "../img/logo4.png"
    ];

    var currentAvatar = 0;
    var avatarImg = document.querySelector(".profile_avatar");

    if (avatarImg) {
        setInterval(function () {
            currentAvatar = (currentAvatar + 1) % avatars.length;
            avatarImg.src = avatars[currentAvatar];
        }, 2000);
    }


    // =========================
    // МОДАЛКА
    // =========================

    var modal = document.getElementById("welcome_modal");
    var closeBtn = document.querySelector(".modal_btn");

    if (modal && closeBtn) {
        closeBtn.addEventListener("click", function () {
            modal.style.display = "none";
        });
    }


    // =========================
    // доп. кнопка
    // =========================

    document.addEventListener("click", function (e) {
        if (e.target && e.target.id === "add_order_btn") {
            location.reload();
        }
    });

});