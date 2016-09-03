<?php
/**
 * User: loveyu
 * Date: 2016/9/4
 * Time: 3:42
 */
require_once __DIR__."/src/CheckChinaGPSLocation.php";
if(isset($_GET['api_key'])) {
	$api_key = $_GET['api_key'];
} elseif(file_exists(__DIR__."/google_key.txt")) {
	$api_key = trim(file_get_contents(__DIR__."/google_key.txt"));
} else {
	die('NO API KEY');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Title</title>
	<style>
		html, body {
			height: 100%;
			margin: 0;
			padding: 0;
		}

		#map {
			height: 100%;
		}
	</style>
</head>
<body>
<div id="map"></div>
<?php
$info = ['main_land' => [], 'hong_kong' => [], 'macao' => [], 'taiwan' => []];

$list = CheckChinaGPSLocation::getMainLandMap();
foreach($list as $item) {
	$info['main_land'][] = ['lat' => $item[0], 'lng' => $item[1]];
}
$list = CheckChinaGPSLocation::getHongKongMap();
foreach($list as $item) {
	$info['hong_kong'][] = ['lat' => $item[0], 'lng' => $item[1]];
}
$list = CheckChinaGPSLocation::getMacaoMap();
foreach($list as $item) {
	$info['macao'][] = ['lat' => $item[0], 'lng' => $item[1]];
}
$list = CheckChinaGPSLocation::getTaiwanMap();
foreach($list as $item) {
	$info['taiwan'][] = ['lat' => $item[0], 'lng' => $item[1]];
}
?>
<script>
	var G_map;
	function initMap() {
		var map = new google.maps.Map(document.getElementById('map'), {
			zoom: 5,
			center: {lat: 37.61423141542417, lng: 104.326171875}
		});
		var poly_map = <?php echo json_encode($info)?>;
		for (var key in poly_map) {
			if (!poly_map.hasOwnProperty(key)) {
				continue;
			}
			var poly = new google.maps.Polyline({
				path: poly_map[key],
				geodesic: true,
				strokeColor: '#FF0000',
				strokeOpacity: 1.0,
				strokeWeight: 2
			});
			poly.setMap(map);
		}

		map.addListener('click', function (e) {
			placeMarkerAndPanTo(e.latLng, map);
		});
		G_map = map;
	}

	function placeMarkerAndPanTo(latLng, map) {
		var marker = new google.maps.Marker({
			position: latLng,
			map: map
		});
		map.panTo(latLng);
		console.log(latLng.lat(), latLng.lng());
	}
</script>
<?php
$param = ['key' => $api_key, 'region' => 'cn', 'language' => 'zh-CN', 'callback' => 'initMap'];
?>
<script src="http://maps.google.cn/maps/api/js?<?php echo http_build_query($param) ?>" type="text/javascript">
</script>
</body>
</html>
