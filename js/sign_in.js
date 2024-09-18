const domLogin = document.getElementById('btnLogin');

domLogin.addEventListener('click', (e) => {
    const email = document.getElementById('signin-email').value;
    const password = document.getElementById('signin-password').value;


    if(email == '' || password == '') {
        changeMessageAlert('Vui lòng nhập đầy đủ thông tin', 'danger');
        return;
    }

    // create new form post html
    var form = document.createElement('form');
    form.setAttribute('method', 'post');
    form.setAttribute('action', 'login.php');
    form.style.display = 'hidden';

    // create new input email
    var inputEmail = document.createElement('input');
    inputEmail.setAttribute('type', 'email');
    inputEmail.setAttribute('name', 'email');
    inputEmail.setAttribute('value', email);
    form.appendChild(inputEmail);

    // create new input password
    var inputPassword = document.createElement('input');
    inputPassword.setAttribute('type', 'password');
    inputPassword.setAttribute('name', 'password');
    inputPassword.setAttribute('value', password);
    form.appendChild(inputPassword);

    // append form to body
    document.body.appendChild(form);

    // submit form
    form.submit();
});