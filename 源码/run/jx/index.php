<?php
try {
    require_once './btjson/basic.php';
    (new basic())->initialize();//初始化播放器
}catch (Exception $exception){
        echo <<<EOF
<html>
	  <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
      <meta name="robots" content="noarchive">
	  <link rel="stylesheet" href="./background/css/jquery.vidbacking.css" type="text/css">
	  <link rel="stylesheet" type="text/css" href="./background/css/normalize.css" />
	  <link rel="stylesheet" type="text/css" href="./background/css/htmleaf-demo.css">
		<link rel="stylesheet" href="./background/css/style2.css" type="text/css">
      <title>提示 - {$exception->getMessage()}</title>
      <style>
      h1{color:#03a9f4; text-align:center; font-family: Microsoft Jhenghei;}p{color:#444; font-size: 1.2rem;text-align:center;font-family: Microsoft Jhenghei;}

      </style>
      </head>
      <body>
	<div class="htmleaf-container">
		<video poster="https://cdn.jsdelivr.net/gh/chch455/tuchuang/7f75c464ac55fcbe5522a18bc96362bb.jpg" autoplay muted loop class="vidbacking">
		        <source src="https://img-baofun.zhhainiao.com/market/b99b51e6c7945c9d5565861d397451cb_preview.mp4" type="video/mp4">
		</video>
		<div class="video-back">
		    <h1>{$exception->getMessage()}</h1>
		    <p>欢迎使用深度视频解析系统</p>
		    <!--<div class="htmleaf-demo center">-->
			<!--<a href="https://www.360mb.net/">源码下载</a>-->
	   	    <!-- <a href="index2.html" class="current">免责声明</a>-->
			</div>-->
		    <div class="clearfix"></div>
		</div>
		
	</div>         
<!--加载js文件-->	  	
		<script src="https://cdn.bootcss.com/jquery/1.11.0/jquery.min.js" type="text/javascript"></script>
	<script>window.jQuery || document.write('<script src="./background/js/jquery-1.11.0.min.js"><\/script>')</script>
	<script src="./background/js/jquery.vidbacking.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function(){
            $('body').vidbacking({
                'masked': true
            });
        });
    </script>
      </body>
      </html>
EOF;
}