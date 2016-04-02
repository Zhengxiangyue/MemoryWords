<html>
    <?php echo $data->msg?>
    user_login
    <form method="post" action="http://ci.form.com/index/login">
        <input type="text" name="username" placeholder="username" value=<?php $data->username?>>
        <input type="password" name="password" placeholder="password" value=<?php $data->password?>>
        <input type="submit" value="Log In">
    </form>
    
    <form method="post" action="http://ci.form.com/index/signup">
        <p id="sign-up">Sign up</p>
        <input type="text" id="sign-up-username" name="su-username" placeholder="username"  value=<?php $data->su_username?>>
        <input type="password" id="sign-up-password" name="su-password" placeholder="password" value=<?php $data->su_password?>>
        <input type="password" id="confirm-password" name="con-password" placeholder="confirm password" value=<?php $data->su_password?>>
        <input type="submit" value="Sign Up">
    </form>
</html>