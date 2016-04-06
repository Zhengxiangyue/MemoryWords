<?php require_once("header.php");?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">


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
                                <a id="user-id"><?php echo $user_id?></a>
                            </li>

                            <li>
                                <a id="button-logout" style="cursor:pointer" onclick="clickLogOut()">退出当前账号</a>
                            </li>
                    </ul>
                </div>

            </nav>
        </div>
    </div>
</header>

<div class="main-body">
    <div class="tabbable" id="tabs-191826">
        <div class="col-md-12 col-sm-12 col-lg-12">

            <!--顶部菜单栏-->
            <div class="row">
                <div class="col-md-1 col-sm-1 col-lg-1"></div>
                <div class="tabbable col-md-10 col-sm-10 col-lg-10" id="tabs-0001">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a data-toggle="tab" href="#my_list">我的单词表</a>
                        </li>
                        <li>
                            <a data-toggle="tab" onclick="return clickBanList()" href="#ban_list">已经记住的单词</a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#collect_list">收藏的单词</a>
                        </li>
                        <li class="disabled">
                            <a href="#">新添词汇表+</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-1 col-lg-1 col-sm-1"></div>
            </div>



            <div class="tab-content">
                <!--背单词-->

                <div class="tab-pane active" id="my_list">
                    <br><br>
                    <div class="row">
                        <div class="col-md-1 col-sm-1 col-lg-1"></div>
                        <div class="col-md-2 col-sm-2 col-lg-2"></div>
                        <div class="col-md-6 col-sm-6 col-lg-6">
                            <div class="row">

                                <!-- 单词卡片 -->
                                <div id="parent-word" class="col-sm-12 col-lg-12 col-md-12" style="background-color: #eeeeee;text-align:center;max-height: 230px; min-height: 230px;padding:40px;min-width: 420px" >
                                    <?php foreach($word_list as $num => $word):?>
                                        <div id="item-<?php echo $num;?>" class="<?php echo $num==0?'now-display':'';?>" style="<?php echo $num==0?'display:block':'display:none';?>">
                                            <p class="big-word" style="font-size: 4em;color: #2fa8ec">
                                                <?php echo $word->Word;?>
                                            </p>
                                            <p style="font-size: 1.1em;color:#999999">
                                                <?php echo $word->meaning;?>
                                            </p>

                                            <i class="fa fa-2x fa-ban" onclick="clickBanButton('<?php echo $word->ID?>')" style="color:#aaaaaa;left:82%;top:80%;position: absolute;cursor:pointer;"></i>

                                            <i class="fa fa-2x fa-plus-square-o" onclick="clickAddButton('<?php echo $word->ID?>')" style="color:#999999;left:90%;top:80%;position: absolute;cursor:pointer;"></i>

                                        </div>
                                    <?php endforeach;?>
                                </div>

                                <br><br>

                            </div>
                        </div>

                        <!--单词卡片右边-->

                        <div class="col-md-2 col-sm-2 col-lg-2">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-lg-12">
                                    <div class="panel-group" id="panel-658172">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" style="padding:4px">
                                                <a class="panel-title collapsed" style="color:#999999" data-toggle="collapse" data-parent="#panel-658172" href="#panel-element-89657">显示/隐藏 进度</a>
                                            </div>
                                            <div id="panel-element-89657" class="progress panel-collapse collapse" style="max-height:20px;margin:2px;background: #ddd">
                                                <div class="progress" style="height:100%">
                                                    <div id="progress-div" class="progress-bar progress-success" style="width:<?php echo 100*(double)(1.0/$word_num)?>%;text-align: left;">
                                                        <p id="progress-p" style="color: #eeeeee;margin-left: 2px">1/<?php echo $word_num?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-1 col-sm-1 col-lg-1"></div>
                    </div>

                    <br><br><br>

                    <!--单词切换提示-->

                    <div class="row" style="text-align:center;color: #aaaaaa">
                        <div class="col-md-12 col-sm-12 col-lg-12"><p><i class="fa fa-arrow-right"></i>一会儿再背 <i class="fa fa-arrow-down"></i>记住了  <i class="fa fa-arrow-left"></i>上一个单词</p></div>
                    </div>

                    <br><br>

                    <!--单词卡片下面两个按钮-->

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-lg-12">
                            <div class="col-md-4 col-sm-4 col-lg-4"> </div>
                            <div class="col-md-2 col-sm-2 col-lg-2" style="text-align: center">

                                <a id="want-to-leave" onclick="return want_to_leave();" href='<?php echo base_url('word/word_ini')?>'><button id="want-to-leave-button" class="btn btn-danger btn-block" >不想背了</button></a>

                            </div>
                            <div class="col-md-2 col-sm-2 col-lg-2">
                                <button id="modal-983501" href="#modal-container-983501" role="button" data-toggle="modal" class="btn btn-success btn-block">
                                    快速查词
                                </button></div>
                            <div class="col-md-4 col-sm-4 col-lg-4"> </div>
                        </div>
                    </div>

                    <br><br>
                </div>

                <!--已经记住的单词-->

                <div class="tab-pane" id="ban_list">
                    <br>
                    <div class="row">
                        <div class="col-md-2 col-sm-2 col-lg-2"></div>
                        <div class="col-md-8 col-sm-8 col-lg-8">
                            <div class="col-md-12">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>
                                            单词
                                        </th>
                                        <th>
                                            词义
                                        </th>
                                        <th>
                                            操作
                                        </th>
                                    </tr>
                                    </thead>
                                    <?php if(!empty($ban_list)){?>
                                    <tbody id="tbody_ban_list">
                                    <?php foreach($ban_list as $num => $word):?>
                                        <tr>
                                            <td>
                                                <?php echo $word->Word;?>
                                            </td>
                                            <td>
                                                <?php echo $word->meaning;?>
                                            </td>
                                            <td>
                                                Default
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                    </tbody>
                                    <?php }?>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-lg-2"></div>
                    </div>
                </div>

                <!--收藏的单词-->

                <div class="tab-pane" id="collect_list">
                    <div class="row">
                        <div class="col-md-1 col-sm-1 col-lg-1"></div>
                        <div class="col-md-2 col-sm-2 col-lg-2"></div>
                        <div class="col-md-6 col-sm-6 col-lg-6"></div>
                        <div class="col-md-2 col-sm-2 col-lg-2"></div>
                        <div class="col-md-1 col-sm-1 col-lg-1"></div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<!--弹框-->

        <div class="modal fade" id="modal-container-983501" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            ×
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                            刷单词词典
                        </h4>
                    </div>

                    <div class="modal-body" style="border-bottom:1px">
                        <div class="col-sm-4">
                               <input type="text" id="subject" class="form-control" onkeydown="if(window.event.keyCode == 13){updateContent();}" placeholder="请输入单词或句子"/>
                        </div>
                            <button type="submit" id = "search-button" type="button" onClick="updateContent()" class="btn btn-default">
                                查询
                            </button>
                            <div id = "word-content" class="col-lg-12 col-sm-12">
                                <h1 id = "word-content-search"></h1>
                                <h4 id = "word-content-meaning"></h4>
                            </div>
                    </div>


                    <div class="modal-footer" style="border-top: 0px">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
</body>


<script type="text/javascript" language=JavaScript charset="UTF-8">
    document.onkeydown=function(event){
        var e = event || window.event || arguments.callee.caller.arguments[0];
        if(e && e.keyCode==37){ // 按 left
            clickButtonPrev();
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

    //从有道api获取词义并查询,显示单词与词义
    function updateContent()
    {
        var content = document.getElementById("subject").value;

        if(content == ''){
            return false;
        }

        if( (content).indexOf('<') === 0 ||
            (content).indexOf('/') === 0 ||
            (content).indexOf('>') === 0 ||
            (content).indexOf('.') === 0 ||
            (content).indexOf('\\') === 0 ||
            (content).indexOf('"') === 0){
            alert('亲,能输人话不?');
            return false;
        }

        document.getElementById("word-content-meaning").innerHTML = "加载中...";
        document.getElementById("word-content-search").innerHTML = "";

        $.ajax({
            url: "http://fanyi.youdao.com/openapi.do?keyfrom=CANCELmemoryWORD&key=723851899&type=data&doctype=jsonp&version=1.1&q=" + content,
            type: 'GET',
            dataType: 'JSONP',//here
            success: function (data) {
                document.getElementById("word-content-search").innerHTML = content;
                document.getElementById("word-content-meaning").innerHTML = data.translation;
            }
        });
    }

    //用不到,点击登录
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
                    window.location.href = "<?php echo base_url('word/index')?>";
                }
            }
        });
    }

    //点击登出
    function clickLogOut(){
        $.ajax({
            url: "<?PHP echo base_url('word/logout')?>",
            type: 'get',
            dataType: 'JSON',//here
            success: function (data) {
                if(data.code == 0){
                    alert('成功登出!');
                    window.location.href = "<?php echo base_url('word/index')?>";
                }
            }
        });
    }

    //点击记住了按钮
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

                accomplish();

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

    //点击下一个按钮
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

    //点击前一个单词按钮
    function clickButtonPrev(){
        var curElement = document.getElementsByClassName('now-display');
        curElement = curElement[0];

        if(curElement != curElement.parentNode.firstElementChild){

            //隐藏当前元素
            curElement.className = '';
            curElement.style = 'display:none';

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

    //完成任务时与后台沟通的方法
    function accomplish(){
        add_success_days();

        modify_package_index();
        change_card_success_content();
        block_want_to_leave();
    }

    //增加完成天数
    function add_success_days(){
        $.ajax({
            url: "<?PHP echo base_url('word/toady_accomplish_add_days')?>",
            type: 'post',
            dataType: 'JSON',//here
            data: {
                username:'<?php echo $user_id;?>',
            },
            success: function (data) {
                if(data.code == 0){
                    alert('同步完成!');
                }else{
                    alert(data.msg);
                }
            }
        });
    }

    //完成任务时改变卡片内容
    function change_card_success_content(){
        document.getElementById('parent-word').innerHTML="<h1>恭喜您,今天的任务已经完成!</h1>"
    }

    //改变单词库下一次出现单词的位置
    function modify_package_index(){
        $.ajax({
            url: "<?PHP echo base_url('word/today_accomplish_modify_package_index')?>",
            type: 'post',
            dataType: 'JSON',//here
            data: {
                username:'<?php echo $user_id;?>',
                cards_num:'<?php echo $word_num?>'
            },
            success: function (data) {
                if(data.code == 0){
                    alert('包index同步完成!');
                }else{
                    alert(data.msg);
                }
            }
        });
    }

    //完成任务时改变想离开按钮内容
    function block_want_to_leave(){
        document.getElementById('want-to-leave-button').innerHTML='完成任务';
        document.getElementById('want-to-leave').onclick='return true;';
    }

    function addCardsNum(){
        $.ajax({
            url: "<?PHP echo base_url('word/add_cards_num')?>",
            type: 'post',
            dataType: 'JSON',//here
            data: {
                username:'<?php echo $user_id;?>',
            },
            success: function (data) {
                if(data.code == 0){
                    alert('数量更新成功');
                }else{
                    alert(data.msg);
                }
            }
        });
    }

    //点击想离开按钮提醒用户没有完成任务
    function want_to_leave(){
        if(confirm('您当前的任务还没有完成,确定要离开吗?')){
            addCardsNum();
            return true;
        }
        return false;
    }

    function addToMyList(){
        //获得当前单词
    }

    function clickBanButton(ban_word){
        $.ajax({
            url: "<?PHP echo base_url('word/ban_word')?>",
            type: 'post',
            dataType: 'JSON',//here
            data: {
                username:'<?php echo $user_id;?>',
                ban_word_id:ban_word,
            },
            success: function (data) {
                if(data.code == 0){
                    alert('该单词将不会再次出现');
                    clickButtonBye();
                }else{
                    alert(data.msg);
                }
            }
        });
    }

    function clickAddButton(add_word){
        $.ajax({
            url: "<?PHP echo base_url('word/add_collection')?>",
            type: 'post',
            dataType: 'JSON',//here
            data: {
                username:'<?php echo $user_id;?>',
                add_word_id:add_word,
            },
            success: function (data) {
                if(data.code == 0){
                    alert('收藏成功!');
                }else{
                    alert(data.msg);
                }
            }
        });
    }

    //
    function clickBanList(){

        $.ajax({
            url: "<?PHP echo base_url('word/ban_list_innerhtml')?>",
            type: 'post',
            dataType: 'JSON',//here
            data: {
                username:'<?php echo $user_id;?>'
            },
            success: function (data) {
                if(data.code == 0){
                    document.getElementById('tbody_ban_list').innerHTML = data.msg;
                }else{
                    alert(data.msg);
                }
            }
        });



        //从后台获取最新的ban_list
//                    document.getElementById('tbody_ban_list').innerHTML="<?php //foreach($ban_list as $num => $word):?>//"+
//                        "<tr>"+
//                        "<td>"+
//                        "<?php //echo htmlspecialchars($word->Word);?>//"+
//                        "</td>"+
//                        "<td>"+
//                        <?php //echo htmlspecialchars($word->meaning);?>// +
//                        "</td>"+
//                        "<td>"+
//                        "<a style='margin-right:2px' href='#'>撤回</a>"+
//                        "<a style='margin-right:2px' href='#'>有多远滚多远</a>"+
//                        "</td>"+
//                        "</tr>"+
//                        "<?php //endforeach;?>//";
        return true;
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