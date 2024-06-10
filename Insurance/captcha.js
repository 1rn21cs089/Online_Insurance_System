document.addEventListener("DOMContentLoaded", function () {
    generate();
});

function generate() {
    document.getElementById("submit").value = "";

    let captcha = document.getElementById("captcha-image");
    if (captcha) {
        let uniquechar = "";
        const randomchar = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for (let i = 1; i < 5; i++) {
            uniquechar += randomchar.charAt(Math.random() * randomchar.length)
        }

        captcha.innerHTML = uniquechar;
    } else {
        console.error("Element with ID 'captcha-image' not found.");
    }
}

function printmsg(event) {
    event.preventDefault();
    const usr_input = document.getElementById("submit").value;
    const captchaValue = document.getElementById("captcha-image").innerHTML;

    if (usr_input == captchaValue) {
        document.getElementById("key").innerHTML = "Matched";
    } else {
        document.getElementById("key").innerHTML = "Not Matched";
        generate();
    }
}