function pwd_check() {
    var conpwd = document.getElementById("con-pwd").value;				
    var pwd = document.getElementById("pwd").value;
    console.log('checking password.', conpwd, pwd);
    return conpwd == pwd;
}
