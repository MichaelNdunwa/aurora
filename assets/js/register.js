// const container = document.getElementById('container');
// const registerBtn = document.getElementById('register-button');
// const loginBtn = document.getElementById('login-button');
// const registerTxt = document.getElementById('register-text');
// const loginTxt = document.getElementById('login-text');

// registerBtn.addEventListener('click', () => {
//     container.classList.add("active");
// });
// loginBtn.addEventListener('click', () => {
//     container.classList.remove("active");
// });

// registerTxt.addEventListener('click', () => {
//     container.classList.add("active");
// });
// loginTxt.addEventListener('click', () => {
//     container.classList.remove("active");
// });

$(document).ready(function() {
    $('#register-button, #register-text').click(function() {
        $('#container').addClass('active');
    });

    $('#login-button, #login-text').click(function() {
        $('#container').removeClass('active');
    });
});