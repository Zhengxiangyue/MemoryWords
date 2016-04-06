<?php require_once("header.php"); ?>
<body>
<header class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
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

<div class="container-fluid">
    <div class="tabbable" id="tabs-0000001">
        <div class="col-md-12 col-sm-12 col-lg-12"">

            <!--顶部菜单栏-->
            <div class="row">
                <div class="col-lg-1 col-md-1 col-sm-1"></div>
                <div class="tabbable col-md-10 col-lg-10 col-sm-10" id="tabs-0002">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a data-toggle="tab" href="#word-initial">背单词</a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#ban_list">已经记住的单词</a>
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

            <br>


            <div class="tab-content">

                <!--开始背单词选项-->

                <div class="tab-pane active" id="word-initial">
                    <div class="row">
                        <div class="col-md-1 col-lg-1 col-sm-1"></div>
                        <div class="col-md-10 col-lg-10 col-sm-10">

                            <div style="text-align: center">
                                <h1 style="color: #2aabd2">我坚持了<?php echo $days;?>天背我的词汇表</h1>
                                <h1>累计刷了<?php echo '0';//$cards_num?>张单词卡片</h1>
                            </div>

                            <br>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 col-lg-2 col-sm-2"></div>
                        <div class="col-md-8 col-lg-8 col-sm-8" style="text-align: center">
                            <form method="post"  action="<?php echo base_url('word/word')?>">

                                <div class="btn-group">

                                    <?php if($if_accomplish_today){?>
                                    <a id="word-num" class="btn btn-default">
                                        今天我还要背
                                    </a>
                                    <?php }else{?>
                                    <a id="word-num" class="btn btn-default">
                                        今天我要背
                                    </a>
                                    <?php }?>
                                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">

                                        <li onclick="changeNum(20)">
                                            <a>20个</a>
                                        </li>
                                        <li>
                                            <a onclick="changeNum(50)">50个</a>
                                        </li>
                                        <li>
                                            <a onclick="changeNum(100)">100个</a>
                                        </li>
                                    </ul>
                                </div>

                                <input type="hidden" name="words_num" id="words_num" value="0">
                                <button id="button-bebgin-memory" onclick="return beginWord()" type="submit" class="btn btn-info" style="margin-left: 5px">
                                    开始背单词
                                </button>
                            </form>
                        </div>
                        <div class="col-md-2 col-lg-2 col-sm-2"></div>
                    </div>

                    <div class="row">
                        <br><br>
                        <div class="col-md-3 col-lg-3 col-sm-3"></div>
                        <div class="col-md-6 col-lg-6 col-sm-6">

                            <?php if($if_accomplish_today){?>

                                <div class="alert alert-dismissable alert-success">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                        ×
                                    </button>
                                    <h4>
                                        恭喜您!
                                    </h4> 今天的单词任务已经完成!
                                </div>

                            <?php }else{?>
                                <div class="alert alert-dismissable alert-warning">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                        ×
                                    </button>
                                    今天的单词还没有背完!
                                </div>

                            <?php }?>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-3"></div>
                    </div>
                </div>

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

                <div class="tab-pane" id="collect_list">
                    hahahha
                </div>



            </div>


        </div>
    </div>
</div>



<?php //require_once("footer.php");?>

</body>

<script>

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

    function beginWord(){
        if(document.getElementById('words_num').value == 0){
            alert('请选择今天要背的单词数量!');
            return false;
        }
        alert(document.getElementById('words_num').value);
        return true;
    }

    function changeNum(num){
        document.getElementById('word-num').innerHTML = "今天我要背" +num+ "个单词";
        document.getElementById('words_num').value=num;
    }
</script>
