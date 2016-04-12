<?php
$facebook = new Facebook(array(
    'appId' => '549567871741754', // needed for JS SDK, Social Plugins and PHP SDK
    'secret' => 'c15a20dec1d41b78e9ef267814ac4c0f'
        ));

//get user from facebook object
$user = $facebook->getUser();
?>
<html>
    <head>

        <title>Dreamfeed: A Better News Feed for All!</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Dreamfeed">
        <meta name="keyword" content="Dreamfeed">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <link rel="icon" href="favicon.ico" type="image/x-icon">


        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/dc.css"/>

    </head>
    <body>
        <style>
            .form-signin {
                max-width: 400px; 
                display:block;
                background-color: #f7f7f7;
                -moz-box-shadow: 0 0 3px 3px #888;
                -webkit-box-shadow: 0 0 3px 3px #888;
                box-shadow: 0 0 3px 3px #888;
                border-radius:2px;
            }
            .main{
                padding: 38px;
            }
            .social-box{
                margin: 0 auto;
                padding: 38px;
                border-bottom:1px #ccc solid;
            }
            .social-box a{
                font-weight:bold;
                font-size:18px;
                padding:8px;
            }
            .social-box a i{
                font-weight:bold;
                font-size:20px;
            }
            .heading-desc{
                font-size:20px;
                font-weight:bold;
                padding:38px 38px 0px 38px;

            }
            .form-signin .form-signin-heading,
            .form-signin .checkbox {
                margin-bottom: 10px;
            }
            .form-signin .checkbox {
                font-weight: normal;
            }
            .form-signin .form-control {
                position: relative;
                font-size: 16px;
                height: 20px;
                padding: 20px;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }
            .form-signin .form-control:focus {
                z-index: 2;
            }
            .form-signin input[type="text"] {
                margin-bottom: 10px;
                border-radius: 5px;

            }
            .form-signin input[type="password"] {
                margin-bottom: 10px;
                border-radius: 5px;
            }
            .login-footer{
                background:#f0f0f0;
                margin: 0 auto;
                border-top: 1px solid #dadada;
                padding:20px;
            }
            .login-footer .left-section a{
                font-weight:bold;
                color:#8a8a8a;
                line-height:19px;
            }
            .mg-btm{
                margin-bottom:20px;
            }
        </style>
    <center>
        <div class="container">
            <div class="row">
                <form class="form-signin mg-btm">
                    <h3 class="heading-desc">
                        Login to DreamFeed</h3>
                    <div class="social-box">
                        <div class="row mg-btm">
                            <div class="col-md-12">
                                <?php
                                $loginUrl = $facebook->getLoginUrl(array(
                                    'diplay' => 'popup',
                                    'scope' => 'user_friends, read_stream',
                                    'redirect_uri' => Yii::app()->getBaseUrl(true) . '/index.php/user/index/159'
                                ));
//                                echo CHtml::button('Login', array('class' => 'btn fix-btn', 'submit' => $loginUrl));
                                ?>
                                <a href="<?php echo $loginUrl ?>" class="btn btn-primary btn-block">
                                    <i class="icon-facebook"></i>    Signup with Facebook
                                </a>
                            </div>
                        </div>

                    </div>
                    <div class="main">	

                        <input type="text" class="form-control" placeholder="Email" autofocus>
                        <input type="password" class="form-control" placeholder="Password">

                        <span class="clearfix"></span>	
                    </div>
                    <div class="login-footer">
                        <div class="row">
                            <div class="col-xs-6 col-md-6">
                                <div class="left-section">
                                    <a href="">Forgot your password?</a>
                                </div>
                            </div>
                            <div class="col-xs-6 col-md-6 pull-right">
                                <button type="submit" class="btn btn-large btn-danger pull-right">Login</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </center>
</body>