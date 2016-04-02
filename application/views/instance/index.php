<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script src=<?php echo base_url('static/js/instance/modernizr-custom.js')?>></script>


    <link rel='stylesheet' type='text/css' href='http://fonts.useso.com/css?family=Open+Sans:300,400,600,700,400italic'>
    <link rel="stylesheet" type="text/css" href=<?php echo base_url('static/css/instance/bootstrap.min.css');?>>
    <link rel="stylesheet" type="text/css" href=<?php echo base_url('static/css/instance/ekko-lightbox.min.css');?>>
    <link rel="stylesheet" type="text/css" href=<?php echo base_url('static/css/instance/style.css')?>>

    <link rel="stylesheet" type="text/css" href=<?php echo base_url('static/css/instance/normalize.css')?> />

    <link rel="stylesheet" type="text/css" href=<?php echo base_url('static/css/instance/demo.css?t=2')?> />
    <link rel="stylesheet" type="text/css" href=<?php echo base_url('static/css/instance/component.css?t=2')?> />
    <link rel="stylesheet" type="text/css" href=<?php echo base_url('static/css/instance/fxsmall.css')?> />
    <script src=<?php base_url('static/js/roll/modernizr.custom.js')?>></script>
    <title><?php echo $MW_title?></title>
</head>

<body>





<header id="">
    <div class="container-fluid">

        <div class="row">

            <div class="col-lg-4 col-md-12 site-title">
                <h1><?php echo $MW_site_head?></h1>
            </div>

            <div class="col-lg-8 col-md-12 main-menu">

                <nav class="navbar navbar-light">
                  <ul class="nav navbar-nav single-page-nav">
                    <li class="nav-item">
                      <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href=<?php echo base_url('word/word_list')?>>Word List</a>
                    </li>

                      <?php if(empty($user_id)){?>
                    <li class="nav-item" href="#modal-container-602247" role="button" data-toggle="modal">
                      <a class="nav-link">Sign In</a>
                        <?php }else{?>
                      <li class="nav-item">
                          <a class="nav-link" href="#home"><?php echo $user_id?></a>
                      </li>
                          <li class="nav-item">
                              <a class="nav-link" style="cursor:pointer" onclick="clickLogOut()">Log out</a>
                          </li>
                      <?php }?>
                    </li>
                  </ul>
                </nav>

            </div>

        </div>

        <div class="row">
            <div class="col-md-12">
            	<hr class="sigma-hr">
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-sm-6">
                <div class="col-lg-8 col-sm-6" style="margin-bottom: 7px;">
                    <input type="text" onkeydown="if(window.event.keyCode == 13){updateContent();}" class="form-control" id="subject" placeholder="input unfamiller word">
                </div>

                <div class="col-lg-4 col-sm-6">
                       <button id = "search-button" type="button" onClick="updateContent()" class="btn btn-sm btn-success">Search</button>
                </div>
            </div>

            <div id = "word-content" class="col-lg-8 col-sm-6">
                <h1 id = "word-content-search"></h1>
                <p id = "word-content-meaning"></p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <hr class="sigma-hr">
            </div>
        </div>

    </div>
    
</header>

<br>
<br>
<br>


<section id="home">
	<div class="container-fluid" id="word-family">
    <?php foreach($word_list as $num => $word):?>
        <div class="row single-page-nav" id="item-<?php echo $num;?>" style="<?php echo $num == 0?'display:block':'display:none'?>">
        	<div>
                <div class="item active">
                    <div class = "col-md-4 col-lg-4"></div>
                    <div class="sigma-content col-lg-4 col-md-4 sigma-bg-lightgray text-center" style="height:40%;padding:0;border: 40px;min-width: 370px;">
                        <div id = id="card-<?php echo $num?>>
                            <h1 style="font-size:3em;color:#16C4FE" ><?php echo $word->Word?></h1>
                            <p style="font-size:1em;color:#858585"><?php echo $word->meaning?></p>
                        </div>
                    </div>
                    <div class = "col-md-4 col-lg-4">
                        <div class = "col-md-2 col-lg-2">
                            <p id="word-count-number"><?php echo ($num+1)."/".count($word_list)?></p>
                        </div>
                        <div class = "col-lg-10 col-md-10">
                            <button class="btn btn-sm btn-success" onclick="clickButtonBye('<?php echo $num?>')">bye</button>
                            <button class="btn btn-sm" onclick="clickButtonSeeU('<?php echo $num?>')">see your later</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach;?>
	</div>
    
</section>

<!--<section id="about">-->
<!---->
<!--	<div class="container-fluid">-->
<!--    -->
<!--    	<div class="row sigma-section-header">-->
<!--        	<div class="col-md-offset-2 col-lg-offset-3 col-lg-6 col-md-8 col-sm-12 text-center">-->
<!--        		<h1>今天我背了89个单词</h1>-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        -->
<!--	</div>-->
<!--</section>-->

<footer>
	<div class="container-fluid">
    
    	<div class="row">
            <div class="col-md-12">
            	<hr class="sigma-hr">
            </div>
        </div>

        <div class="row">
        	<div class="sigma-copyright col-lg-8">
            	<p>Copyright © Lypton Cancel </a></p>
            </div>
            
            <div class="sigma-copyright col-lg-4 single-page-nav text-right">
            	<p><a href="#top">Go to top</a></p>
            </div>
        </div>
        
    </div>   

</footer>


<!--登录弹窗-->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="modal fade" id="modal-container-602247" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">

                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                ×
                            </button>
                            <h4 class="modal-title" id="myModalLabel">
                                Sign In
                            </h4>
                        </div>

                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form role="form">
                                            <div class="form-group">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" id="formSignInId" placeholder="ID"/>
                                                </div>
                                                <div class="col-md-3"></div>

                                            </div>
                                            </br>
                                            <div class="form-group">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-6">
                                                    <input type="password" class="form-control" id="formSignInPassword" placeholder="Password"/>
                                                </div>
                                                <div class="col-md-3"></div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Back
                            </button>
                            <button type="button" onclick="clickSignIn()" class="btn btn-primary">
                                Log in
                            </button>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>

<script src=<?php echo base_url('static/js/roll/classie.js')?>></script>
<script src=<?php echo base_url('static/js/roll/main.js?t=4')?>></script>

        <script>


            function updateContent()
            {
                document.getElementById("word-content-meaning").innerHTML = "加载中...";
                document.getElementById("word-content-search").innerHTML = "";

                var content = document.getElementById("subject").value;
                $.ajax({
                    url: "http://fanyi.youdao.com/openapi.do?keyfrom=CANCELmemoryWORD&key=723851899&type=data&doctype=jsonp&version=1.1&q=" + content,
                    type: 'GET',
                    dataType: 'JSONP',//here
                    success: function (data) {
                        //alert(translation);
                        document.getElementById("word-content-search").innerHTML = content;
                        document.getElementById("word-content-meaning").innerHTML = data.translation;
                    }
                });
            }

            function clickSignIn(){
                var input_user_name = document.getElementById("formSignInId").value;
                var input_password = document.getElementById("formSignInPassword").value;

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
                            window.location.href = "<?php echo base_url('word')?>";
                        }
                    }
                });
            }

            function clickLogOut(){
                $.ajax({
                    url: "<?PHP echo base_url('word/logout')?>",
                    type: 'get',
                    dataType: 'JSON',//here
                    success: function (data) {
                        if(data.code == 0){
                            alert('成功登出!');
                            window.location.href = "<?php echo base_url('word')?>";
                        }
                    }
                });
            }

            function clickButtonBye(num){

                var curElement = document.getElementById('item-' + num);

                //把当前元素加入到readyRemove class
                curElement.className += ' readyRemove';

                //隐藏当前元素
                curElement.style = 'display:none';

                //如果一轮结束,删除readyRemove class中的元素 显示第一个元素
                if(curElement != curElement.parentNode.lastElementChild){
                    //显示下一个元素
                    curElement.nextElementSibling.style = 'display:block';
                }
                else{
                   var parentElement = curElement.parentNode;
                    $('.readyRemove').remove();
                    //parentElement.firstChild.style = 'display:block';//.style = 'display:block';//.firstElementChild.style = 'display:block';
                    //alert(parentElement.firstElementChild.id);
                    parentElement.firstElementChild.style = 'display:block';
                }
            }

            function clickButtonSeeU(num){

                var curElement = document.getElementById('item-' + num);

                //隐藏当前元素
                curElement.style = 'display:none';

                //如果当前节点是同级最后一个元素,删除readyRemove class中的元素 显示第一个元素
                if(curElement != curElement.parentNode.lastElementChild){
                    //显示下一个元素
                    curElement.nextElementSibling.style = 'display:block';
                }
                else{
                    var parentElement = curElement.parentNode;
                    $('.readyRemove').remove();
                    //parentElement.firstChild.style = 'display:block';//.style = 'display:block';//.firstElementChild.style = 'display:block';
                    //alert(parentElement.firstElementChild.id);
                    parentElement.firstElementChild.style = 'display:block';
                }
            }
        </script>

<!--<script type="text/javascript" language=JavaScript charset="UTF-8">-->
<!--    document.onkeydown=function(event){-->
<!--        var e = event || window.event || arguments.callee.caller.arguments[0];-->
<!--        if(e && e.keyCode==37){ // 按 左键-->
<!--            //要做的事情-->
<!--        }-->
<!--        if(e && e.keyCode==39){ // 按 右键-->
<!--            alert('adsfafd');-->
<!--        }-->
<!--    };-->
<!--</script>-->


</body>
</html>
