<?php require_once("header.php"); ?>
<body>
    <header class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <nav class="navbar navbar-default" role="navigation">

                    <div class="navbar-header">
                        <a class="navbar-brand" href="#">我爱刷单词</a>
                    </div>

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a id="modal-00001" href="#modal-container-00001" data-toggle="modal">登陆</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <br><br><br><br><br><br><br><br>

    <div class="main-body">
        <div class="col-md-12 col-sm-12">
            <div class="row">
                <div class="col-md-4 col-sm-4">
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">

                            <button type="button" id="modal-00002" href="#modal-container-00002" data-toggle="modal" class="btn btn-lg btn-block btn-success">
                                注册
                            </button>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <a href="<?php echo base_url('word/random_25')?>">
                            <button type="button" class="btn btn-lg btn-block btn-info">
                                随便来25个
                            </button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                </div>
            </div>
        </div>


    </div>

    <div id="window-login">
        <div class="modal fade" id="modal-container-00001" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            ×
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                            欢迎登陆
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3 col-sm-3">
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <form role="form">
                                    <div class="form-group">
                                        <label>用户名</label>
                                        <input type="text" class="form-control" id="login-username" placeholder="ID/E-mail address"/>
                                    </div>
                                    <div class="form-group">
                                        <label>密码</label>
                                        <input type="password" class="form-control" id="login-password" />
                                    </div>

                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" /> 记住账户15天
                                        </label>
                                        <a id="wrong-password" style="display: none;">密码错误</a>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-3 col-sm-3">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            关闭
                        </button>

                        <button type="button" onclick="clickSignIn()" class="btn btn-success">
                            登陆
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="window-signup">
        <div class="modal fade" id="modal-container-00002" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            ×
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                            新用户注册
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3 col-sm-3">
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <form role="form">

                                    <div class="form-group">
                                        <label>登录名</label>
                                        <input type="text" class="form-control" id="signup-username" placeholder="ID/E-mail address"/>
                                    </div>

                                    <div class="form-group">
                                        <label>密码</label>
                                        <input type="password" class="form-control" id="signup-password" />
                                    </div>

                                    <div class="form-group">
                                        <label>确认密码</label>
                                        <input type="password" class="form-control" id="signup-confirm" />
                                    </div>

                                    <p id="not-maching" style="display:none">密码不一致</p>

                                </form>
                            </div>
                            <div class="col-md-3 col-sm-3">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Close
                        </button>

                        <button type="button" onclick="return clickSignUp()" class="btn btn-success">
                            注册
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>

<!--    <footer>-->
<!--            <div class="container-fluid">-->
<!---->
<!--                <div class="row">-->
<!--                    <div class="col-md-12">-->
<!--                        <hr class="sigma-hr">-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!--                <div class="row">-->
<!--                    <div class="sigma-copyright col-lg-8">-->
<!--                        <p>Copyright © Lypton Cancel </a></p>-->
<!--                    </div>-->
<!---->
<!--                    <div class="sigma-copyright col-lg-4 single-page-nav text-right">-->
<!--                        <p><a href="#top">Go to top</a></p>-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!--            </div>-->
<!--    </footer>-->
</body>

<script>

    function clickSignIn(){
        var input_user_name = document.getElementById("login-username").value;
        var input_password = document.getElementById("login-password").value;

        $.ajax({
            url: "<?PHP echo base_url('word/login')?>",
            type: 'post',
            data: {
                username:input_user_name,
                password:input_password,
            },
            dataType: 'JSON',//here
            success: function (data) {
                if(data.code == 0){
                    window.location.href = "<?php echo base_url('word/word_ini')?>";
                }
                else{
                    document.getElementById('wrong-password').style="color:#990000;display:block";
                }
            }
        });
    }

    function clickSignUp(){
        var signup_username = document.getElementById("signup-username").value;
        var signup_password = document.getElementById("signup-password").value;
        var signup_confirm = document.getElementById("signup-confirm").value;

        if(signup_password != signup_confirm){
            alert("两次密码不一致");
            return false;
            //document.getElementById("not-maching").style="display:block";
        }

        $.ajax({
            url: "<?PHP echo base_url('word/signup')?>",
            type: 'post',
            data: {
                username:signup_username,
                password:signup_password,
            },
            dataType: 'JSON',//here
            success: function (data) {
                if(data.code == 0){
                    alert("注册成功!");
                    window.location.href = "<?php echo base_url('word/index')?>";
                }
                else{
                    alert(data.msg);
                }
            }
        });

    }

</script>


