<?php
function readGPSinfoEXIF()
{
     $exif=exif_read_data('test.jpg', 0, true);

     if(!$exif || $exif['GPS']['GPSLatitude'] == '') 
     { 
          return false;
          echo "No GPS DATA in EXIF METADATA"; 
     } 
     else 
     { 
          $lat_ref = $exif['GPS']['GPSLatitudeRef']; 
          $lat = $exif['GPS']['GPSLatitude'];
          list($num, $dec) = explode('/', $lat[0]);
          $lat_s = $num / $dec;
          list($num, $dec) = explode('/', $lat[1]);
          $lat_m = $num / $dec;
          list($num, $dec) = explode('/', $lat[2]);
          $lat_v = $num / $dec;

          $lon_ref = $exif['GPS']['GPSLongitudeRef'];
          $lon = $exif['GPS']['GPSLongitude'];
          list($num, $dec) = explode('/', $lon[0]);
          $lon_s = $num / $dec;
          list($num, $dec) = explode('/', $lon[1]);
          $lon_m = $num / $dec;
          list($num, $dec) = explode('/', $lon[2]);
          $lon_v = $num / $dec;
          $gps_int = array($lat_s + $lat_m / 60.0 + $lat_v / 3600.0, $lon_s
                     + $lon_m / 60.0 + $lon_v / 3600.0);
          return $gps_int;
     }
}

$results = readGPSinfoEXIF();
$lat = $results[0];
$lng = $results[1] * 1;

$cord1 = str_replace(",",".",$lat);
$cord2 = str_replace(",",".",$lng);

	echo ('
	{
        "fields": {
			"coords": "['.$cord1.', '.$cord2.']",
			"photo": ""
		
        }
    }');

?>