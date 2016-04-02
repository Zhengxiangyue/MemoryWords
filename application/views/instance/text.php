<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo base_url();?>static/static/bootstrap-3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <script src="<?php echo base_url();?>static/static/jquery-2.1.4/jquery.min.js"></script>
    <script src="<?php echo base_url();?>static/static/bootstrap-3.3.5/js/bootstrap.min.js"></script>
</head>
<script>

</script>

<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <nav class="navbar navbar-default" role="navigation">

                <div class="navbar-header">
                    <a class="navbar-brand" href="#">LOVE WORDS</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">

                        <li>
                            <a id="modal-00001" href="#modal-container-00001" data-toggle="modal">Log In</a>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">About Me<strong class="caret"></strong></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="#">Action</a>
                                </li>
                                <li>
                                    <a href="#">Another action</a>
                                </li>
                                <li>
                                    <a href="#">Something else here</a>
                                </li>
                                <li class="divider">
                                </li>
                                <li>
                                    <a href="#">Separated link</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>

            </nav>
        </div>
    </div>

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <div class="row">


                    <div class="col-md-7" style="background-color: #eeeeee;text-align:center" >
<!--                       --><?php //foreach:?>
                        <div>
                           <p class="big-word" style="font-size: 4em;color: #2fa8ec">
                               head
                           </p>
                           <p>
                               n.头,标题,重要位置
                           </p>
                           <p>
                               <a class="btn" href="#">查看例句 »</a>
                           </p>
                       </div>
                    </div>


                    <div class="col-md-5">
                        <div class="col-md-1">

                        </div>
                        <div class="col-md-11">
                            <div class="progress active progress-striped">
                                <div class="progress-bar progress-success" style="width:61.8%">
                                    <p>61/100</p>
                                </div>
                            </div>
                            <button type="button" class="btn active btn-block btn-sm btn-success">
                                NEXT
                            </button>
                            <button type="button" class="btn active btn-block btn-sm btn-danger">
                                BYE
                            </button>
                            <button type="button" class="btn active btn-block btn-sm btn-success">
                                PRE
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-container-00001" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Log In
                </h4>
            </div>
            <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-6">
                            <form role="form">
                                <div class="form-group">

                                    <label>User name</label>
                                    <input type="text" class="form-control" id="login-username" placeholder="ID/E-mail address"/>
                                </div>
                                <div class="form-group">

                                    <label>Password</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" />
                                </div>

                                <div class="checkbox">

                                    <label>
                                        <input type="checkbox" /> Remember me for 15 days
                                    </label>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-3">
                        </div>
                </div>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Close
                </button>
                <button type="button" class="btn btn-success">
                    Log in
                </button>
            </div>
        </div>

    </div>

</div>


</body>