<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo base_url();?>static/static/bootstrap-3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <script src="<?php echo base_url();?>static/static/jquery-2.1.4/jquery.min.js"></script>
    <script src="<?php echo base_url();?>static/static/bootstrap-3.3.5/js/bootstrap.min.js"></script>
</head>


<body>
<header class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <nav class="navbar navbar-default" role="navigation">

                <div class="navbar-header">
                    <a class="navbar-brand" href="#">我爱刷单词</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <?php if(empty($user_id)){?>
                            <li>
                                <a id="modal-00001" href="#modal-container-00001" data-toggle="modal">Log In</a>
                            </li>
                        <?php }else{?>
                            <li>
                                <a id="user-id"><?php echo $user_id?></a>
                            </li>

                            <li>
                                <a id="button-logout" style="cursor:pointer" onclick="clickLogOut()">退出当前账号</a>
                            </li>

                        <?php }?>
                    </ul>
                </div>

            </nav>
        </div>
    </div>
</header>



<div class="main-body">
    <div class="col-md-12 col-lg-12">
        <div class="row">
            <div class="col-md-1 col-lg-1"></div>
            <div class="col-md-10 col-lg-10">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#my_list">我的单词表</a>
                    </li>
                    <li>
                        <a href="#cet4_list">四级词汇</a>
                    </li>
                    <li>
                        <a href="#cet6_list">六级词汇</a>
                    </li>
                    <li class="disabled">
                        <a href="#">新添词汇表+</a>
                    </li>
                </ul>
            </div>
        </div>

        <br><br><br>

        <div class="row">
            <div class="col-md-1 col-lg-1"></div>
            <div class="col-md-2 col-lg-2">
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="row">

                    <!-- 背单词 -->
                    <div id="parent-word" class="col-md-12 col-lg-12" style="background-color: #eeeeee;text-align:center;max-height: 230px; min-height: 230px;padding:40px" >
                        <?php $now_display = 0;?>
                        <?php foreach($word_list as $num => $word):?>
                            <div id="item-<?php echo $num;?>" class="<?php echo $num==0?'now-display':'';?>" style="<?php echo $num==0?'display:block':'display:none';?>">
                                <p class="big-word" style="font-size: 4em;color: #2fa8ec">
                                    <?php echo $word->Word;?>
                                </p>
                                <p style="font-size: 1.1em;color:#999999">
                                    <?php echo $word->meaning;?>
                                </p>
<!--                                <p style="font-size: 1.1em">-->
<!--                                    --><?php //echo $word->lx;?>
<!--                                </p>-->
                            </div>
                        <?php endforeach;?>
                    </div>

                    <br><br>
                </div>
            </div>
            <div class="col-md-2 col-lg-2">
                <div class="progress">
                    <div id="progress-div" class="progress-bar progress-success" style="width:61.8%;text-align: left;">
                        <p style="color: #eeeeee;margin-left: 2px">进度:12/50</p>
                    </div>
                </div>



            </div>
            <div class="col-md-1 col-lg-1"></div>
        </div>

        <br><br><br>

        <div class="row" style="text-align:center;color: #aaaaaa">
            <div class="col-md-12 col-lg-12 "><p>键盘右:一会儿再背  键盘下:记住了  键盘左:上一个单词</p></div>

        </div>

    </div>
</div>
</body>

<script>
    //alert($('#parent-word div').length);
    //if($('#parent-word div').length != 0){
        $(document.body).onbeforeunload="checkLeave()";
    //}
    function checkLeave(){
        event.returnValue="确定离开当前页面吗？";
    }

    //未完成任务时弹框
</script>

<script type="text/javascript" language=JavaScript charset="UTF-8">
    document.onkeydown=function(event){
        var e = event || window.event || arguments.callee.caller.arguments[0];
        if(e && e.keyCode==37){ // 按 left
//要做的事情
        }
        if(e && e.keyCode==39){ // 按 右键
            clickButtonNext();
        }
        if(e && e.keyCode==40){ // 下键
//要做的事情
            clickButtonBye();
        }
    };
</script>

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
                    window.location.href = "<?php echo base_url('word/text')?>";
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
                    window.location.href = "<?php echo base_url('word/text')?>";
                }
            }
        });
    }

    function clickButtonBye(){

        var curElement = document.getElementsByClassName('now-display');
        curElement = curElement[0];

        //把当前元素加入到readyRemove class
        curElement.className = 'readyRemove';

        //隐藏当前元素
        curElement.style = 'display:none';

        //如果一轮结束,删除readyRemove class中的元素 显示第一个元素
        if(curElement != curElement.parentNode.lastElementChild){
            //显示下一个元素
            curElement.nextElementSibling.style = 'display:block';
            curElement.nextElementSibling.className = 'now-display';
            var progress_molecular = $(curElement.nextElementSibling).index()+1;
            var progress_denominator = $('#parent-word div').length;
            document.getElementById('progress-p').innerHTML =  progress_molecular + '/' + progress_denominator;

            //改变显示progress条
            var progress_molecular = $(curElement.nextElementSibling).index()+1;
            var progress_denominator = $('#parent-word div').length;
            document.getElementById('progress-p').innerHTML =  progress_molecular + '/' + progress_denominator;
            var percentage =  100 * parseFloat(progress_molecular)/parseFloat(progress_denominator);
            document.getElementById('progress-div').style = "width:"+ percentage + "%";
        }
        else{
            var parentElement = curElement.parentNode;
            $('.readyRemove').remove();

            //如果已经没有元素了,弹窗提示今天的任务完成
            if(parentElement.childElementCount === 0){
                alert('今天的任务完成');
            }


            parentElement.firstElementChild.style = 'display:block';
            parentElement.firstElementChild.className = 'now-display';

            //获取数量分子和分母
            var progress_molecular = $( parentElement.firstElementChild).index()+1;
            var progress_denominator = $('#parent-word div').length;
            //改变数量分子和分母
            document.getElementById('progress-p').innerHTML =  progress_molecular + '/' + progress_denominator;
            //改变progress
            var percentage =  100 * parseFloat(progress_molecular)/parseFloat(progress_denominator);
            document.getElementById('progress-div').style = "width:"+ percentage + "%";
        }
    }

    function clickButtonNext(){
        var curElement = document.getElementsByClassName('now-display');
        curElement = curElement[0];

        //隐藏当前元素
        curElement.className = '';
        curElement.style = 'display:none';

        //如果一轮结束,删除readyRemove class中的元素 显示第一个元素
        if(curElement != curElement.parentNode.lastElementChild){
            //显示下一个元素
            curElement.nextElementSibling.style = 'display:block';
            curElement.nextElementSibling.className = 'now-display';

            //改变显示progress条
            var progress_molecular = $(curElement.nextElementSibling).index()+1;
            var progress_denominator = $('#parent-word div').length;
            document.getElementById('progress-p').innerHTML =  progress_molecular + '/' + progress_denominator;
            var percentage =  100 * parseFloat(progress_molecular)/parseFloat(progress_denominator);
            document.getElementById('progress-div').style = "width:"+ percentage + "%";
        }
        else{
            //删掉bye的单词
            var parentElement = curElement.parentNode;
            $('.readyRemove').remove();
            //显示第一个单词
            parentElement.firstElementChild.style = 'display:block';
            parentElement.firstElementChild.className = 'now-display';

            var progress_molecular = $( parentElement.firstElementChild).index()+1;
            var progress_denominator = $('#parent-word div').length;
            document.getElementById('progress-p').innerHTML =  progress_molecular + '/' + progress_denominator;

            //改变显示progress条
            var percentage =  100 * parseFloat(progress_molecular)/parseFloat(progress_denominator);
            document.getElementById('progress-div').style = "width:"+ percentage + "%";
        }
    }

    function clickButtonPrev(){
        var curElement = document.getElementsByClassName('now-display');
        curElement = curElement[0];

        //隐藏当前元素
        curElement.className = '';
        curElement.style = 'display:none';

        //如果一轮结束,删除readyRemove class中的元素 显示第一个元素
        if(curElement != curElement.parentNode.firstElementChild){
            //显示上一个元素
            curElement.previousElementSibling.style = 'display:block';
            curElement.previousElementSibling.className = 'now-display';

            //改变显示progress条
            var progress_molecular = $(curElement.previousElementSibling).index()+1;
            var progress_denominator = $('#parent-word div').length;
            document.getElementById('progress-p').innerHTML =  progress_molecular + '/' + progress_denominator;
            var percentage =  100 * parseFloat(progress_molecular)/parseFloat(progress_denominator);
            document.getElementById('progress-div').style = "width:"+ percentage + "%";
        }
        else{
            alert('这是第一个单词!');
        }
    }

    function updateProgress(){
        parentElement = document.getElementById('parent-word');
        curElement = document.getElementsByClassName('now-display')[0];
        var curTh = $('.now-display')[0].index();
        $('#progress-div').style.width=(float)
    }
</script>

<!--keyCode 8 = BackSpace BackSpace-->
<!--keyCode 9 = Tab Tab-->
<!--keyCode 12 = Clear-->
<!--keyCode 13 = Enter-->
<!--keyCode 16 = Shift_L-->
<!--keyCode 17 = Control_L-->
<!--keyCode 18 = Alt_L-->
<!--keyCode 19 = Pause-->
<!--keyCode 20 = Caps_Lock-->
<!--keyCode 27 = Escape Escape-->
<!--keyCode 32 = space-->
<!--keyCode 33 = Prior-->
<!--keyCode 34 = Next-->
<!--keyCode 35 = End-->
<!--keyCode 36 = Home-->
<!--keyCode 37 = Left-->
<!--keyCode 38 = Up-->
<!--keyCode 39 = Right-->
<!--keyCode 40 = Down-->
<!--keyCode 41 = Select-->
<!--keyCode 42 = Print-->
<!--keyCode 43 = Execute-->
<!--keyCode 45 = Insert-->
<!--keyCode 46 = Delete-->
<!--keyCode 47 = Help-->
<!--keyCode 48 = 0 equal braceright-->
<!--keyCode 49 = 1 exclam onesuperior-->
<!--keyCode 50 = 2 quotedbl twosuperior-->
<!--keyCode 51 = 3 section threesuperior-->
<!--keyCode 52 = 4 dollar-->
<!--keyCode 53 = 5 percent-->
<!--keyCode 54 = 6 ampersand-->
<!--keyCode 55 = 7 slash braceleft-->
<!--keyCode 56 = 8 parenleft bracketleft-->
<!--keyCode 57 = 9 parenright bracketright-->
<!--keyCode 65 = a A-->
<!--keyCode 66 = b B-->
<!--keyCode 67 = c C-->
<!--keyCode 68 = d D-->
<!--keyCode 69 = e E EuroSign-->
<!--keyCode 70 = f F-->
<!--keyCode 71 = g G-->
<!--keyCode 72 = h H-->
<!--keyCode 73 = i I-->
<!--keyCode 74 = j J-->
<!--keyCode 75 = k K-->
<!--keyCode 76 = l L-->
<!--keyCode 77 = m M mu-->
<!--keyCode 78 = n N-->
<!--keyCode 79 = o O-->
<!--keyCode 80 = p P-->
<!--keyCode 81 = q Q at-->
<!--keyCode 82 = r R-->
<!--keyCode 83 = s S-->
<!--keyCode 84 = t T-->
<!--keyCode 85 = u U-->
<!--keyCode 86 = v V-->
<!--keyCode 87 = w W-->
<!--keyCode 88 = x X-->
<!--keyCode 89 = y Y-->
<!--keyCode 90 = z Z-->
<!--keyCode 96 = KP_0 KP_0-->
<!--keyCode 97 = KP_1 KP_1-->
<!--keyCode 98 = KP_2 KP_2-->
<!--keyCode 99 = KP_3 KP_3-->
<!--keyCode 100 = KP_4 KP_4-->
<!--keyCode 101 = KP_5 KP_5-->
<!--keyCode 102 = KP_6 KP_6-->
<!--keyCode 103 = KP_7 KP_7-->
<!--keyCode 104 = KP_8 KP_8-->
<!--keyCode 105 = KP_9 KP_9-->
<!--keyCode 106 = KP_Multiply KP_Multiply-->
<!--keyCode 107 = KP_Add KP_Add-->
<!--keyCode 108 = KP_Separator KP_Separator-->
<!--keyCode 109 = KP_Subtract KP_Subtract-->
<!--keyCode 110 = KP_Decimal KP_Decimal-->
<!--keyCode 111 = KP_Divide KP_Divide-->
<!--keyCode 112 = F1-->
<!--keyCode 113 = F2-->
<!--keyCode 114 = F3-->
<!--keyCode 115 = F4-->
<!--keyCode 116 = F5-->
<!--keyCode 117 = F6-->
<!--keyCode 118 = F7-->
<!--keyCode 119 = F8-->
<!--keyCode 120 = F9-->
<!--keyCode 121 = F10-->
<!--keyCode 122 = F11-->
<!--keyCode 123 = F12-->
<!--keyCode 124 = F13-->
<!--keyCode 125 = F14-->
<!--keyCode 126 = F15-->
<!--keyCode 127 = F16-->
<!--keyCode 128 = F17-->
<!--keyCode 129 = F18-->
<!--keyCode 130 = F19-->
<!--keyCode 131 = F20-->
<!--keyCode 132 = F21-->
<!--keyCode 133 = F22-->
<!--keyCode 134 = F23-->
<!--keyCode 135 = F24-->
<!--keyCode 136 = Num_Lock-->
<!--keyCode 137 = Scroll_Lock-->
<!--keyCode 187 = acute grave-->
<!--keyCode 188 = comma semicolon-->
<!--keyCode 189 = minus underscore-->
<!--keyCode 190 = period colon-->
<!--keyCode 192 = numbersign apostrophe-->
<!--keyCode 210 = plusminus hyphen macron-->
<!--keyCode 211 =-->
<!--keyCode 212 = copyright registered-->
<!--keyCode 213 = guillemotleft guillemotright-->
<!--keyCode 214 = masculine ordfeminine-->
<!--keyCode 215 = ae AE-->
<!--keyCode 216 = cent yen-->
<!--keyCode 217 = questiondown exclamdown-->
<!--keyCode 218 = onequarter onehalf threequarters-->
<!--keyCode 220 = less greater bar-->
<!--keyCode 221 = plus asterisk asciitilde-->
<!--keyCode 227 = multiply division-->
<!--keyCode 228 = acircumflex Acircumflex-->
<!--keyCode 229 = ecircumflex Ecircumflex-->
<!--keyCode 230 = icircumflex Icircumflex-->
<!--keyCode 231 = ocircumflex Ocircumflex-->
<!--keyCode 232 = ucircumflex Ucircumflex-->
<!--keyCode 233 = ntilde Ntilde-->
<!--keyCode 234 = yacute Yacute-->
<!--keyCode 235 = oslash Ooblique-->
<!--keyCode 236 = aring Aring-->
<!--keyCode 237 = ccedilla Ccedilla-->
<!--keyCode 238 = thorn THORN-->
<!--keyCode 239 = eth ETH-->
<!--keyCode 240 = diaeresis cedilla currency-->
<!--keyCode 241 = agrave Agrave atilde Atilde-->
<!--keyCode 242 = egrave Egrave-->
<!--keyCode 243 = igrave Igrave-->
<!--keyCode 244 = ograve Ograve otilde Otilde-->
<!--keyCode 245 = ugrave Ugrave-->
<!--keyCode 246 = adiaeresis Adiaeresis-->
<!--keyCode 247 = ediaeresis Ediaeresis-->
<!--keyCode 248 = idiaeresis Idiaeresis-->
<!--keyCode 249 = odiaeresis Odiaeresis-->
<!--keyCode 250 = udiaeresis Udiaeresis-->
<!--keyCode 251 = ssharp question backslash-->
<!--keyCode 252 = asciicircum degree-->
<!--keyCode 253 = 3 sterling-->
<!--keyCode 254 = Mode_switch-->
<!--使用event对象的keyCode属性判断输入的键值-->
<!--eg：if(event.keyCode==13)alert(“enter!”);-->
<!--键值对应表-->
<!--A　　0X65 　U 　　0X85-->
<!--B　　0X66　 V　　 0X86-->
<!--C　　0X67　 W　　 0X87-->
<!--D　　0X68　 X 　　0X88-->
<!--E　　0X69　 Y　　 0X89-->
<!--F　　0X70　 Z　　 0X90-->
<!--G　　0X71　 0　　 0X48-->
<!--H　　0X72　 1　　 0X49-->
<!--I　　0X73　 2　　 0X50-->
<!--J　　0X74　 3 　　0X51-->
<!--K　　0X75　 4 　　0X52-->
<!--L　　0X76　 5 　　0X53-->
<!--M　　0X77　 6　　 0X54-->
<!--N　　0X78 　7 　　0X55-->
<!--O　　0X79 　8 　　0X56-->
<!--P　　0X80 　9 　　0X57-->
<!--Q　　0X81　ESC　　0X1B-->
<!--R　　0X82　CTRL 　0X11-->
<!--S　　0X83　SHIFT　0X10-->
<!--T　　0X84　ENTER　0XD-->