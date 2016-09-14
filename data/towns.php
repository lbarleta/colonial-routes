<?php

$key = "saihackerlazarento";
require_once("..\config\conn2.php");

$year = $_GET['year'];

# Build SQL SELECT statement and return the geometry as a GeoJSON element in EPSG: 4326
$sql = "
	select nome, codigo, inicio, termino, periodo, hierarquia, classificacaomirim, ST_AsGeoJSON(ponto) as geojson
		from busca_geral
		where tipo_de_geometria = 'ponto'
			and classificacaomirim IN (186, 187, 185, 238)
			and ponto is not null
			and cast(inicio as int) <= cast(". $year ." as int)
			and cast(termino as int) >= cast(". $year ." as int)
";




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
