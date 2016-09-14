<?php

$key = "saihackerlazarento";
require_once("..\config\conn.php");

// Queries
$sql = "SELECT name,
			   ST_AsGeoJSON(ST_Multi(ST_Collect(f.geom))) as geojson
			 FROM (SELECT name, (ST_Dump(geom)).geom As geom
						FROM
						caminhos ) As f
		GROUP BY name";

// Basic query, not merged
// $sql = "SELECT ST_AsGeoJSON(geom) as geojson, name, id FROM caminhos";
		
# Try query or error
$rs = pg_query($conn, $sql);
if (!$rs) {
    echo "An SQL error occured.\n";
    exit;
}
# Build GeoJSON
$output    = '';
$rowOutput = '';
while ($row = pg_fetch_assoc($rs)) {
    $rowOutput = (strlen($rowOutput) > 0 ? ',' : '') . '{"type": "Feature", "geometry": ' . $row['geojson'] . ', "properties": {';
    $props = '';
    $id    = '';
    foreach ($row as $key => $val) {
        if ($key != "geojson") {
            $props .= (strlen($props) > 0 ? ',' : '') . '"' . $key . '":"' . escapeJsonString($val) . '"';
        }
        if ($key == "id") {
            $id .= ',"id":"' . escapeJsonString($val) . '"';
        }
    }
    
    $rowOutput .= $props . '}';
    $rowOutput .= $id;
    $rowOutput .= '}';
    $output .= $rowOutput;
}
$output = '{ "type": "FeatureCollection", "features": [ ' . $output . ' ]}';
echo $output;
?>
