<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title></title>
		<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
		<script src="index.php"></script>
		<script>
            wx.config({
                debug: false,
                appId: '<?php echo $signPackage["appId"];?>',
                timestamp: <?php echo $signPackage["timestamp"];?>,
                nonceStr: '<?php echo $signPackage["nonceStr"];?>',
                signature: '<?php echo $signPackage["signature"];?>',
                jsApiList: [
                    // 所有要调用的 API 都要加到这个列表中
                    'checkJsApi',
                    'openLocation',
                    'getLocation',
                    'onMenuShareTimeline',
                    'onMenuShareAppMessage'
                ]
            });
			wx.ready(function(){
			    // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。
				alert("成功");
			});
			wx.error(function(res){
			    // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
				alert("失败");
			});
			
			function scanQR() {
				wx.scanQRCode({
				    needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
				    scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
				    success: function (res) {
					    var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
						alert(result);
				    }
				});
			}
			
			function getLoc() {
				wx.getLocation({
				    type: 'gcj02', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
				    success: function (res) {
				        var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
				        var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
				        var speed = res.speed; // 速度，以米/每秒计
				        var accuracy = res.accuracy; // 位置精度
				        document.getElementById("output").innerHTML = 
				        "纬度:" + latitude 
				        + "<br>经度:" + longitude
				        + "<br>速度:" + speed
				        + "<br>位置精度:" + accuracy;
				        
						wx.openLocation({
						    latitude: latitude, // 纬度，浮点数，范围为90 ~ -90
						    longitude: longitude, // 经度，浮点数，范围为180 ~ -180。
						    name: '我的位置', // 位置名
						    address: '北科', // 地址详情说明
						    scale: 28, // 地图缩放级别,整形值,范围从1~28。默认为最大
						    infoUrl: 'http://www.baidu.com' // 在查看位置界面底部显示的超链接,可点击跳转
						});
				    }
				});
			}
		</script>
		<style>
			button {
				margin: 100px 20px;
			}
		</style>
	</head>
	<body>
		<button type="button" onclick="scanQR()">扫一扫</button>
		<button type="button" onclick="getLoc()">取得位置</button>
		<div id="output"></div>
	</body>
</html>
