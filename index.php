<!DOCTYPE HTML><html><head>
	<title>FEBuild - </title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	
	<?php require_once(dirname(__FILE__). '/febuild.class.php'); FEBuild::Run('{
		"config": {
			"environment": "develop",
			"root_path": "/srv/www/test.local/public_html",
			"version": "0.1" 
		},
		"style": [
			"style/common.less",
			"style/general.css",
			{
				"src": "style/print.css",
				"media": "print"
			}
		],
		"javascript": [
			"script/lib/jquery.js",
			"script/general.js",
			"script/custom.js"
		]
	}'); ?>
	
</head><body>
	
	<!-- Page -->
	<pre id="page">

	</pre>
	
</body></html>