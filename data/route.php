<?php

$key = "saihackerlazarento";
require_once("..\config\conn.php");

// Definitions
$network_table = 'caminhos';
$vertices_table = 'caminhos_vertices_pgr';
$elevation_table = 'elevation';
$srid = 4326;

$dep = getLatLong($_GET['departure']);
$arr = getLatLong($_GET['arrival']);

// Get closest departure vertex
$sql = "SELECT id, ST_Distance(vert.the_geom, ST_PointFromText ('". $dep['wkt'] ."', ".$srid.")), ST_PointFromText ('". $dep['wkt'] ."', ".$srid.")
			FROM ". $vertices_table ." vert
			ORDER BY vert.the_geom <-> ST_PointFromText ('". $dep['wkt'] ."', ".$srid.")
			LIMIT 1;";
$res = pg_query($conn, $sql);
$departure = pg_fetch_row($res);

// Get closest arrival vertex
$sql = "SELECT id, ST_Distance(vert.the_geom, ST_PointFromText ('". $arr['wkt'] ."', ".$srid.")), ST_PointFromText ('". $arr['wkt'] ."', ".$srid.")
			FROM ". $vertices_table ." vert
			ORDER BY vert.the_geom <-> ST_PointFromText ('". $arr['wkt'] ."', ".$srid.")
			LIMIT 1;";
$res = pg_query($conn, $sql);
$arrival = pg_fetch_row($res);



// Get the closest route between departure and arrival vertices
$sql = "SELECT seq, name, id1 AS source, id2 AS edge, size, cost, ele.rastervalu, ST_AsText(pt.geom) as wkt, ST_AsGeoJSON(pt.geom) as geojson 
	FROM pgr_dijkstra( '
		SELECT id, name, source, target, st_length(geom::geography) as cost, size 
		FROM ". $network_table ."', ". $departure[0] .", ". $arrival[0] .", false, false ) as di 
	JOIN ". $network_table ." pt 
		ON di.id2 = pt.id
	JOIN ". $elevation_table ." ele
		ON ele.id_0 = pt.source
	ORDER BY seq";
		
/*
$sql = " SELECT seq, id1 AS node, id2 AS edge, cost, ST_AsGeoJSON(geom) as geojson
  FROM pgr_dijkstra(
    'SELECT id, source, target, st_length(geom) as cost FROM ". $network_table ."',
    ". $departure[0] .", ". $arrival[0] .", false, false
  ) as di
  JOIN ". $network_table ." pt
  ON di.id2 = pt.id";
*/
  
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
