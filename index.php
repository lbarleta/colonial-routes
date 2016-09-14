<?php 

require_once('/config/lang.php');

$lang = (isset($_GET['lang'])) ? $_GET['lang'] : 'en';

?>

<!doctype html>
<html lang="<?php echo $lang; ?>">
<head>
	
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php echo $sys[$lang][10]; ?>">

    <title><?php echo $sys[$lang][0]; ?></title>
	<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">

	<!--[if lte IE 8]>
		<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/grids-responsive-old-ie-min.css">
	<![endif]-->
	<!--[if gt IE 8]><!-->
		<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/grids-responsive-min.css">
	<!--<![endif]-->
  
    <!--[if lte IE 8]>
        <link rel="stylesheet" href="css/layouts/blog-old-ie.css">
    <![endif]-->
    <!--[if gt IE 8]><!-->
        <link rel="stylesheet" href="css/layouts/blog.css">
    <!--<![endif]-->
	
	<style>
		body{
			overflow:hidden;
		}
		
		.menu-box {
			border-bottom: 1px solid #eee;
			padding: 2% 0;
			margin: 0 10%;
			text-align: left;
			font-size: 0.9em;
		}
		
		#route-steps {
			margin: 2%;
			border: 1px solid #eee;
			background-color: #ffffff;
		}
		
		#routing {
			margin: 5% auto;
			text-align: center;		
		}
		
		#menu {
			margin: 5% auto;
			text-align: center;		
		}
		
		#translate {
			margin: 5% auto;
			text-align: center;		
		}
		
		#elev-block { 
			width: 75%; 
			height: 150px;
			/* border: 3px solid #000; */
			background-color: #fff;
			cursor: move;
			padding: 15px 10px 5px 10px;
			border-radius: 15px;
			box-shadow: 4px 4px 15px 2px rgba(0,0,0,0.16), 0px 0px 13px 5px rgba(0,0,0,0.12) !important;
		}
		
		#elev-graph { 
			width: 100%; 
			height: 100%;
			/* border: 1px solid #000; */
			letter-spacing: normal;
		}
		
		#export-block { 
			width: 75%; 
			height: 75%;
			/* border: 3px solid #000; */
			background-color: #fff;
			padding: 15px 10px 5px 10px;
			border-radius: 15px;
			box-shadow: 4px 4px 15px 2px rgba(0,0,0,0.16), 0px 0px 13px 5px rgba(0,0,0,0.12) !important;
			border: 1px solid black;
		}
		
		#warn-empty-graph {
			width: 100%;
			text-align: center;
			letter-spacing: normal;
		}
		
		#texts {
			background-color: #fff;
			padding: 25px;
			overflow:auto;
		}
	</style>
	
</head>
<body>

<div id="layout" class="pure-g">
    <div class="sidebar pure-u-1 pure-u-md-1-4">
        <div class="header">
            <h1 class="brand-title"><?php echo $sys[$lang][0]; ?></h1>
            <!--<h2 class="brand-tagline">Atlas Digital da América Lusa</h2>-->
			<!--
            <nav class="nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a class="pure-button" href="#">Sobre</a>
                    </li>
                    <li class="nav-item">
                        <a class="pure-button" href="#">Textos</a>
                    </li>
                </ul>
            </nav>
			-->
        </div>		
		
		<div id="routing">
			<a class="pure-button pure-button-primary" id="btn-route"><?php echo $sys[$lang][1]; ?></a>
			<input type="hidden" id="hiddenRoute" value="0">
			<input type="hidden" id="counterRoute" value="1">
		</div>
		
		<div class="menu-box" id="markers">
			<div><?php echo $sys[$lang][2]; ?>: <span id="text-departure"><span></div>
			<div><?php echo $sys[$lang][3]; ?>: <span id="text-arrival"><span></div>
		</div>
		
		<div class="menu-box" id="properties">
			<div><?php echo $sys[$lang][4]; ?>: <span id="text-distance"><span></div>
			<div><?php echo $sys[$lang][5]; ?>: <span id="text-time"><span></div>
			<div><?php echo $sys[$lang][6]; ?>: <span id="text-cost"><span></div>
			<div><?php echo $sys[$lang][7]; ?>: <span id="text-elevation"><a href="#"><?php echo $sys[$lang][8]; ?></a><span></div>
		</div>
		
		<!--
		<div class="menu-box" id="route">
			<div>Rota:</div>
			<div id="route-steps">
				Seguir pela Estrada 1 <br/>
				Mudar para Rota 2 </br>
				Seguir pela Estrada 1 <br/>
				Mudar para Rota 2 </br>
			</div>
		</div>
		-->
		
		<!--
		<div class="menu-box">
			<div>Exportar: <a href="#" id="text-export">PNG</a></div>
		</div>
		-->
		
		<div id="menu">
			<a href="#" id="btn-about"><?php echo $sys[$lang][9]; ?></a><br />
		</div>
		
		<div id="translate">
			<a href="?lang=pt"><img src="img/brasil.png" height="20"></a>&nbsp;
			<a href="?lang=en"><img src="img/usa.png" height="20"></a>
		</div>
    </div>

    <div class="content pure-u-1 pure-u-md-3-4" id="visualization">
		<div id="map" style="width:100%; height: 100%"></div>

		<div id="elev-block">
			<div id="warn-empty-graph"><?php echo $sys[$lang][11]; ?></div>
			<div id="elev-graph"></div>
		</div>
		
	</div>
	
	
	<div id="export-block">
	</div>
	
    <div class="content pure-u-1 pure-u-md-3-4" id="texts">
	
		<div id="list-menu">
			<ul>
				<li><a href="#about"><?php echo $txt[$lang][0]; ?></a></li>
				<li><a href="#methodology"><?php echo $txt[$lang][1]; ?></a>
					<ul>
						<li><a href="#georeferencing"><?php echo $txt[$lang][2]; ?></a></li>
						<li><a href="#time"><?php echo $txt[$lang][3]; ?></a></li>
						<li><a href="#cost"><?php echo $txt[$lang][4]; ?></a></li>
					</ul>
				</li>
				<li><a href="#data"><?php echo $txt[$lang][5]; ?></a></li>
				<li><a href="#authors"><?php echo $txt[$lang][6]; ?></a></li>
				<li><a href="#citation"><?php echo $txt[$lang][7]; ?></a></li>
			</ul>
		</div>
		<div id="about">
			<h2>Sobre</h2>

			<p>O projeto Caminhos Coloniais é um modelo virtual da rede de transportes do Brasil colonial que reconstitui diversas ruas, estradas, caminhos, picadas, rios e rotas marítimas percorridas por vários indivíduos durante o período. O objetivo é fornecer uma ferramenta que permita pesquisadores, estudantes e público em geral compreender com as pessoas, animais e objetos circulavam no interior de um vasto território que foi gradualmente penetrado, devassado e, enfim, incorporado nos domínios da Coroa portuguesa no Novo Mundo. Além das rotas percorridas, o projeto ainda fornece alguns elementos para que as experiências de itinerância – o tempo ganho no caminho, os custos envolvidos, o relevo e obstáculos naturais – do passado colonial sejam melhor entendidas por estudiosos do presente.</p>

			<p>A contribuição do projeto é pensar os domínios portugueses na América – o Brasil colonial – a partir da conectividade entre lugares e pessoas e as condições físicas para a realização de tais ligações. Estudos sobre o Brasil colonial tendem privilegiar o lugar (a vila, a freguesia) ou a região (a área mineradora, a zona açucareira), frequentemente assumindo a conexão destes com o complexo da América portuguesa. O foco de Caminhos Coloniais, pois, foca nestas conexões, revelando a forma e a capacidade de movimentação de indivíduos e os mecanismos de estabelecimento e manutenção de tais relações.</p>

			<!--<p>O projeto é uma parceria entre o Atlas Digital da América Lusa, criado e mantido pelo Laboratório de História Social (UnB), e o Center for Spatial and Textual Analysis, da Universidade de Stanford.</p>-->
			
			<p><a href="#list-menu"><?php echo $txt[$lang][8]; ?></a>
		</div>
		<div id="methodology">
			<h2>Metodologia</h2>
			
			<h3 id="georeferencing">Georreferenciamento</h3>
			
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam egestas diam sit amet odio hendrerit molestie. Praesent pharetra est non lorem viverra consectetur fringilla nec orci. Cras condimentum eget risus vitae vehicula. Aenean in malesuada elit. Suspendisse vel odio convallis, ultricies erat id, pretium nisl. Nam tempus consectetur tristique. Maecenas ut ex sit amet est accumsan aliquet quis quis tellus. Proin id ligula auctor, mattis nunc vel, consectetur leo. Ut at est eget urna vestibulum congue in a elit. Donec convallis eget elit finibus placerat. Proin at lobortis lectus. Nam facilisis orci vestibulum, efficitur nunc nec, varius magna.</p>

			<p>Etiam blandit eu justo sit amet luctus. Sed placerat enim lorem, ullamcorper pulvinar mauris sodales quis. Nam semper eget orci sit amet vulputate. Nam non aliquet enim. Sed nec fringilla nulla. Nam sed viverra erat. Nunc vitae purus libero. In nec mollis lacus.</p>

			<p>Suspendisse malesuada, ante sit amet luctus sollicitudin, diam tellus lacinia justo, et pharetra libero quam vel magna. Donec quis iaculis justo, quis euismod sem. Sed imperdiet ligula ut nulla sagittis sodales. Curabitur vehicula erat non risus porttitor dictum vel et justo. Donec ac leo purus. Vestibulum tristique, nisi nec posuere elementum, mi nulla luctus tellus, in luctus tellus est et risus. Suspendisse ut justo est. Nam vitae aliquam metus.</p>

			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla bibendum a erat non egestas. Praesent gravida semper risus, vitae ultricies enim porttitor ac. Nam augue ex, ornare quis enim in, fringilla feugiat ligula. Maecenas ut suscipit nisi. Sed at rutrum arcu. Suspendisse potenti. Curabitur faucibus aliquam urna non viverra. Sed dignissim lorem sed justo pulvinar commodo. Donec elementum fringilla tellus, eu aliquam turpis cursus at. Morbi laoreet non elit at porta. Quisque sit amet consequat lectus.</p>

			<p>Aliquam malesuada auctor ex nec ultrices. Ut semper mi at nibh congue, sed vulputate leo sollicitudin. Vivamus ut est eu velit posuere sodales ac et lorem. Maecenas posuere sapien enim, in sagittis neque bibendum blandit. Cras congue et nibh nec cursus. Nunc semper, velit non imperdiet pretium, lacus orci volutpat eros, ac mattis diam ligula vel felis. Ut id quam nec justo mollis tempor ut ornare magna. In laoreet aliquet sollicitudin.</p>
			
			<p><a href="#list-menu"><?php echo $txt[$lang][8]; ?></a>
			
			<h3 id="time">Tempo</h3>
			
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam egestas diam sit amet odio hendrerit molestie. Praesent pharetra est non lorem viverra consectetur fringilla nec orci. Cras condimentum eget risus vitae vehicula. Aenean in malesuada elit. Suspendisse vel odio convallis, ultricies erat id, pretium nisl. Nam tempus consectetur tristique. Maecenas ut ex sit amet est accumsan aliquet quis quis tellus. Proin id ligula auctor, mattis nunc vel, consectetur leo. Ut at est eget urna vestibulum congue in a elit. Donec convallis eget elit finibus placerat. Proin at lobortis lectus. Nam facilisis orci vestibulum, efficitur nunc nec, varius magna.</p>

			<p>Etiam blandit eu justo sit amet luctus. Sed placerat enim lorem, ullamcorper pulvinar mauris sodales quis. Nam semper eget orci sit amet vulputate. Nam non aliquet enim. Sed nec fringilla nulla. Nam sed viverra erat. Nunc vitae purus libero. In nec mollis lacus.</p>

			<p>Suspendisse malesuada, ante sit amet luctus sollicitudin, diam tellus lacinia justo, et pharetra libero quam vel magna. Donec quis iaculis justo, quis euismod sem. Sed imperdiet ligula ut nulla sagittis sodales. Curabitur vehicula erat non risus porttitor dictum vel et justo. Donec ac leo purus. Vestibulum tristique, nisi nec posuere elementum, mi nulla luctus tellus, in luctus tellus est et risus. Suspendisse ut justo est. Nam vitae aliquam metus.</p>

			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla bibendum a erat non egestas. Praesent gravida semper risus, vitae ultricies enim porttitor ac. Nam augue ex, ornare quis enim in, fringilla feugiat ligula. Maecenas ut suscipit nisi. Sed at rutrum arcu. Suspendisse potenti. Curabitur faucibus aliquam urna non viverra. Sed dignissim lorem sed justo pulvinar commodo. Donec elementum fringilla tellus, eu aliquam turpis cursus at. Morbi laoreet non elit at porta. Quisque sit amet consequat lectus.</p>

			<p>Aliquam malesuada auctor ex nec ultrices. Ut semper mi at nibh congue, sed vulputate leo sollicitudin. Vivamus ut est eu velit posuere sodales ac et lorem. Maecenas posuere sapien enim, in sagittis neque bibendum blandit. Cras congue et nibh nec cursus. Nunc semper, velit non imperdiet pretium, lacus orci volutpat eros, ac mattis diam ligula vel felis. Ut id quam nec justo mollis tempor ut ornare magna. In laoreet aliquet sollicitudin.</p>
			
			<p><a href="#list-menu"><?php echo $txt[$lang][8]; ?></a>
			
			<h3 id="cost">Custo</h3>
			
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam egestas diam sit amet odio hendrerit molestie. Praesent pharetra est non lorem viverra consectetur fringilla nec orci. Cras condimentum eget risus vitae vehicula. Aenean in malesuada elit. Suspendisse vel odio convallis, ultricies erat id, pretium nisl. Nam tempus consectetur tristique. Maecenas ut ex sit amet est accumsan aliquet quis quis tellus. Proin id ligula auctor, mattis nunc vel, consectetur leo. Ut at est eget urna vestibulum congue in a elit. Donec convallis eget elit finibus placerat. Proin at lobortis lectus. Nam facilisis orci vestibulum, efficitur nunc nec, varius magna.</p>

			<p>Etiam blandit eu justo sit amet luctus. Sed placerat enim lorem, ullamcorper pulvinar mauris sodales quis. Nam semper eget orci sit amet vulputate. Nam non aliquet enim. Sed nec fringilla nulla. Nam sed viverra erat. Nunc vitae purus libero. In nec mollis lacus.</p>

			<p>Suspendisse malesuada, ante sit amet luctus sollicitudin, diam tellus lacinia justo, et pharetra libero quam vel magna. Donec quis iaculis justo, quis euismod sem. Sed imperdiet ligula ut nulla sagittis sodales. Curabitur vehicula erat non risus porttitor dictum vel et justo. Donec ac leo purus. Vestibulum tristique, nisi nec posuere elementum, mi nulla luctus tellus, in luctus tellus est et risus. Suspendisse ut justo est. Nam vitae aliquam metus.</p>

			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla bibendum a erat non egestas. Praesent gravida semper risus, vitae ultricies enim porttitor ac. Nam augue ex, ornare quis enim in, fringilla feugiat ligula. Maecenas ut suscipit nisi. Sed at rutrum arcu. Suspendisse potenti. Curabitur faucibus aliquam urna non viverra. Sed dignissim lorem sed justo pulvinar commodo. Donec elementum fringilla tellus, eu aliquam turpis cursus at. Morbi laoreet non elit at porta. Quisque sit amet consequat lectus.</p>

			<p>Aliquam malesuada auctor ex nec ultrices. Ut semper mi at nibh congue, sed vulputate leo sollicitudin. Vivamus ut est eu velit posuere sodales ac et lorem. Maecenas posuere sapien enim, in sagittis neque bibendum blandit. Cras congue et nibh nec cursus. Nunc semper, velit non imperdiet pretium, lacus orci volutpat eros, ac mattis diam ligula vel felis. Ut id quam nec justo mollis tempor ut ornare magna. In laoreet aliquet sollicitudin.</p>
			
			<p><a href="#list-menu"><?php echo $txt[$lang][8]; ?></a>
			
		</div>
		
		<div id="data">
			<h2>Dados e fontes</h2>
			
			<p><strong>Caminhos Coloniais</strong> utiliza uma séries de fontes e conjunto de dados produzidos e disponibilizados por diversos autores e instituições. A lista de conjuntos de dados e fontes estão descritas a seguir.</p>
						
			<h3>Dados Geográficos</h3>
			
			<ul>
				<li>Tiles: Natural Earth, <em>Natural Earth II with Shaded Relief, Water, and Drainages, versão 3.2.0</em>. <strong>1:10m Raster Data</strong> [Raster dataset]. Versão de 09/06/2016. Disponível em: <a href="http://www.naturalearthdata.com/downloads/10m-raster-data/10m-natural-earth-2/">http://www.naturalearthdata.com/downloads/10m-raster-data/10m-natural-earth-2/</a>. Tiles servidos pelo Atlas Digital da América Portuguesa.</li>
				<li>Localidades: Gil, Tiago; Barleta, Leonardo (eds.) <em>Localidades, 1800</em>. <strong>Atlas Digital da América Portuguesa</strong> [Dataset]. Acesso em <?php echo date('d/i/Y'); ?>. Disponível em: <a href="http://lhs.unb.br/atlas/geodata/localidades.json?ano=1800">http://lhs.unb.br/atlas/geodata/localidades.json?ano=1800</a>. </li>
				<li>Caminhos: Sobrenome, Nome; Gil, Tiago; Barleta, Leonardo. <em>Caminhos, 1800</em>. <strong>Atlas Digital da América Portuguesa</strong> [Dataset]. Acesso em <?php echo date('d/i/Y'); ?>. Disponível em: <a href="http://lhs.unb.br/atlas/geodata/localidades.json?ano=1800">http://lhs.unb.br/atlas/geodata/caminhos.json?ano=1800</a>.</li>
			</ul>
			
			<h3>Fontes primárias</h3>
			
			<p>Para maiores detalhes sobre a utilização destes materiais, ver <a href="#methodology">Metodologia</a>.</p>
			
			<ul>
				<li>Fonte 1:</li>
				<li>Fonte 2:</li>
				<li>Fonte 3:</li>
			</ul>
		
			<p><a href="#list-menu"><?php echo $txt[$lang][8]; ?></a>
			
		</div>	
		<div id="authors">
			<h2>Autores</h2>
			
			<ul>
				<li>Leonardo Barleta</li>
				<li>Tiago Gil</li>
				<li>Zephyr Frank</li>
				<li>XXXXXXXXXXXXXXXXXXXXXXXXX</li>
			</ul>
			
			<p><a href="#list-menu"><?php echo $txt[$lang][8]; ?></a>
			
		</div>
		<div id="citation">
			<h2>Como citar</h2>
			
			<p>Barleta, Leonardo et al. <strong>Caminhos Coloniais</strong>, 2016. Disponível em: <a href="http://lhs.unb.br/caminhoscoloniais">http://lhs.unb.br/caminhoscoloniais</a>. Acesso em: <?php echo date('d/i/Y'); ?>.</p>
			
			<p><a href="#list-menu"><?php echo $txt[$lang][8]; ?></a>
		</div>
	</div>
</div>


    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>	
	<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  
    <link rel="stylesheet" href="js/leaflet-0.7.5/leaflet.css" />
	
    <script src="js/leaflet-0.7.5/leaflet.js"></script>
    <script src="js/leaflet.ajax.min.js"></script>
	
	<link rel="stylesheet" href="js/leaflet.draw/dist/leaflet.draw.css" />
    <script src="js/leaflet.draw/dist/leaflet.draw.js"></script>
	
    <script src="js/leaflet-image.js"></script>
	
	<link rel="stylesheet" href="js/leaflet.MeasureControl/leaflet.measurecontrol.css" />
    <script src="js/leaflet.MeasureControl/leaflet.measurecontrol.js"></script>
	
	<script src="js/jquery.svg.min.js"></script>
	<script src="js/jquery.svganim.min.js"></script>
	
	<script>	
		// Styles	
        var vila = {
            radius: 1,
			stroke: true,
			color: '#000000',
            fillColor: "#000000",
            fillOpacity: 1,
			weight: 3
       };
	   
        var cidade = {
            radius: 1,
			stroke: true,
			color: '#333',
            fillColor: "#333",
            fillOpacity: 1
       };
	   
        var point = {
            radius: 2,
            fillColor: "#ff7800",
            fillOpacity: 0.8
       };      
	   
	   // Styles - Routing
		var roads = {
			"color": "#333333",
			"weight": 2,
			"opacity": 1
		};
		
		var route = {
			"color": "#ff7800",
			"weight": 10,
			"opacity": 0.4,
			"lineCap": "butt",
			"lineJoint": "butt"
		};
		
		var path2route = {
			"color": "#ff0000",
			"weight": 10,
			"opacity": 0.4
		};
		
	   
		var departureIcon = L.icon({
			iconUrl: 'img/icons/icon-departure.png',
			iconSize:	[19, 35],
			iconAnchor:	[9.5, 35]
		});
	   
		var arrivalIcon = L.icon({
			iconUrl: 'img/icons/icon-arrival.png',
			iconSize:	[19, 35],
			iconAnchor:	[9.5, 35]
		});
	   
	   // Init Map		
        var map = L.map('map', {
			/* drawControl: true, */
			measureControl:true
		}).setView([-14.24, -51.93], 5);
		//}).setView([-22.4, -49.25], 5);
		
		
        // Basemaps
       var Esri_WorldShadedRelief = L.tileLayer('http://server.arcgisonline.com/ArcGIS/rest/services/World_Shaded_Relief/MapServer/tile/{z}/{y}/{x}', {
			format: 'image/png',
			prefereCanvas: "true",
			attribution: 'Tiles &copy; Esri &mdash; Source: Esri',
			maxZoom: 13
		});
		
		var atlas_tiles = L.tileLayer("http://lhs.unb.br/geodata/tiles/{x}+{y}+{z}", {  
			format: 'image/png',
			attribution: 'Tiles &copy; Atlas Digital da América Lusa &mdash; Source: Natural Earth',
			maxZoom: 7
			/* attribution: "Natural Earth" */
		});
		
        Esri_WorldShadedRelief.addTo(map);

        // Layers
       
        function addTowns(year) {
            jsonLocalities = new L.GeoJSON.AJAX("data/towns.php?year="+ year, {
                pointToLayer: function (feature, latlng) {
					if (feature.properties.classificacaomirim == 185) { return L.circleMarker(latlng, vila); }//vila };
					else if (feature.properties.classificacaomirim == 186) { return L.circleMarker(latlng, cidade); } // cidade };
					else if (feature.properties.classificacaomirim == 238) { return L.circleMarker(latlng, vila); } //vila e cabeça de capitania };
					/*
					else if (feature.properties.classificacaomirim == 187) { return L.circleMarker(latlng, cabeca); } //cabeça de capitania };
					*/
                    
                },
                onEachFeature: function(feature, layer) {
                    if (feature.properties && feature.properties.nome) {
                        layer.bindPopup(feature.properties.nome +"<br/>"
										+feature.properties.hierarquia +"<br/>"
										+feature.properties.periodo);
					}
                }
            });
            jsonLocalities.addTo(map);
            
            return jsonLocalities;
        }
        
        var layerTowns = addTowns("1800");
		
		/*
		$("#yearSlider").on('change', function() {
            $("#yearBox").val($(this).val());
            map.removeLayer(layerTowns);
            layerTowns = addTowns($("#yearBox").val());
        });
		*/
		
		// Roads layer
		jsonRoads = new L.GeoJSON.AJAX("data/roads.php", {
			style: roads
		});
		jsonRoads.addTo(map);
		
		// Controls
		var baseMaps = {
			"ESRI World Shade Relief": Esri_WorldShadedRelief,
			"Natural Earth - Atlas Digital da América Lusa": atlas_tiles
		};
		
		var overlayMaps = {
			"Places": layerTowns,
			"Roads": jsonRoads
		};
		
		var layerControl = L.control.layers(baseMaps, overlayMaps, {'collapsed': false}).addTo(map);
		var scaleControl = L.control.scale({'maxWidth': 100}).addTo(map);

		//Routing APP
		// Routing
		var pointDeparture;
		var pointArrival;
		var markerDep;
		var markerArr;
		var cltRoute;
		var jsonRoute;
		
		var distance = 0.0;
		var cost = 0.0;
		var time = 0.0;
		
		var cost_impedance = 146; // $144 reis por km
		var time_impedance = 45; // 15km por dia
		
		function onMapClick(e) {
			state = $("#hiddenRoute").val();
			
			if(state == 1) {
				pointDeparture = e.latlng;				
				markerDep = L.marker(pointDeparture, {icon: departureIcon}).addTo(map);
				$("#text-departure").text(e.latlng.lat.toFixed(5) +', '+e.latlng.lng.toFixed(5));
				$("#hiddenRoute").val(2);
				
			}
			else if(state == 2) {
				pointArrival = e.latlng;
				markerArr = L.marker(pointArrival, {icon: arrivalIcon}).addTo(map);
				$("#text-arrival").text(e.latlng.lat.toFixed(5) +', '+e.latlng.lng.toFixed(5));
				$("#hiddenRoute").val(0);
				$('#map').css('cursor', '');
			}				
				
			if(pointDeparture != undefined && pointArrival != undefined ) {
				alert("Buscando rota...");				
				cltRoute = addRoute(pointDeparture, pointArrival);
				
				layerControl.addOverlay(cltRoute, "Route "+ $("#counterRoute").val());				
				$("#counterRoute").val(parseInt($("#counterRoute").val())+1);
								
				if($("#warn-empty-graph")) {
					$("#warn-empty-graph").remove();
				}
				
				pointDeparture = undefined;
				pointArrival = undefined;
			}				
		}
		
		function wktToLatLng(wkt) {
			
		}
		
		function addRoute(dep, arr) {			
			jsonRoute = new L.GeoJSON.AJAX("data/route.php?departure="+ dep +"&arrival="+ arr, {
				style: route,				
				onEachFeature: function onEachFeature(feature, layer) {
					$(layer).mouseover(function (e) {
						//console.log($('.elevation-segment[id='+ feature.properties.edge +']'));
						$('.elevation-segment').animate({svgStroke: 'rgb(150,150,150)', svgStrokeWidth: 2}, 0);
						$('.elevation-segment[id='+ feature.properties.edge +']').animate({svgStroke: 'rgb(255,0,0)', svgStrokeWidth: 3}, 0);
					});
					$(layer).mouseleave(function (e) {
						$('.elevation-segment').animate({svgStroke: 'rgb(0,0,0)', svgStrokeWidth: 2}, 0);
					});
					
                    //layer.bindPopup("Altitude de partida: " +feature.properties.rastervalu);
				},
				middleware: function(data){
					distance = 0.0;
					$(data.features).each(function(key, value) {
						distance = distance*1 + value.properties.cost*1;
						//console.log(value.properties.wkt); TODO: Varrer para pegar bounds
					});
					$("#text-distance").text((distance/1000).toFixed(2) +'km');
					
					cost = 0.0;
					cost = (distance*cost_impedance).toFixed(0);
					$("#text-cost").text((cost/1000).toFixed(2) +' reis por ton');
					
					time = 0.0;
					time = (distance/time_impedance).toFixed(0);
					$("#text-time").text((time/1000).toFixed(1) +' dias');
					
					drawGraph(svg, data.features, distance);
					
					return(data);
				}
			})
			.addTo(map);
			
			// TODO: Validar vazio
			// Temporary solution: Centralizar na rota
			map.setView([ ((arr.lat+dep.lat)/2), ((arr.lng+dep.lng)/2) ]);
			
			//console.log(jsonRoute.getBounds());
			
			//map.fitBounds(jsonRoute.getBounds());
			//jsonRoute;
			/*
			var geojsonLayer = L.geoJson(your_data).addTo(map);
			*/
			//console.log(jsonRoute.getBounds());
			//console.log(map.fitBounds(jsonRoute.getBounds()));
			return jsonRoute;
		}
		
		
		
		
		
		// Elevation profile				
		$('#elev-graph').svg();
		var svg = $('#elev-graph').svg('get');
		
		/*
		function getMax(obj, field) {
			var max;
			
			$(obj).each(function(key, value) {
				if (!max || parseInt(value.properties.rastervalu) > parseInt(max))
					max = value.properties.rastervalu;
			});
			
			return max;
		}
		*/
		
		function drawGraph(svg, data, distance){			
			$('#elev-block').toggle("blind", 1000);
			svg.clear();
			
			// Definitions
			var margin = 10; // Margins within the SVG canvas
			var grid_itens = 5; // Step of the Grid lines, including 0m
			
			// Base calculations
			//var height_m = getMax(data, "elevation"); //total heigth of the data in m; max elevation
			var height_m = 2500; //total heigth of the data in m; max elevation
			var height_px = (svg.height()-(margin*2)); // total height of the svg canvas in px, minus 5px for the top elevation legend
			var height_prop = height_m/height_px; // height: proportion: meters per pixel
			
			/*
			console.log("altura px: "+ svg.height());
			console.log("altura canvas px: "+ height_px)
			console.log("prop: "+ height_prop);
			*/
			
			var step = Math.ceil(height_m/grid_itens); // distance between grid lines in m	
						
			var width_m = distance; // total width in meters, based on route length
			var width_px = svg.width()-(margin*2); // total width of the SVG canvas in pixels
			var width_prop = width_m/(width_px-25); // width propostion: meters per pixel
			
			// Grid
			var grid = svg.group({stroke: '#CECECE', strokeWidth: 0.5});		
			var elev = svg.group({'fill': '#CECECE', 'font-size': '0.6em', 'font-family': 'Arial', 'text-align': 'left'}); 	
			
			for(i=0;i<=grid_itens;i++) {
				height_i = (i*step)/height_prop+margin;
				svg.line(grid, margin, height_i, width_px-20, height_i)
				svg.text(elev, width_px-17, height_i, (height_m-(i*step)) +"m")
			}
			
			// Elevation line
			var position = margin;			
			var last = "";
			var g = svg.group({stroke: 'black', strokeWidth: 2});
			//var g = svg.group({stroke: 'black', strokeWidth: 2, 'stroke-linecap': "round"});
						
			$(data).each(function(key, value) {
				if(last != "") {
					end_point = position+(value.properties.cost/width_prop);
					svg.line(g, position, margin+(height_px-(last/height_prop)), end_point, margin+(height_px-(parseFloat(value.properties.rastervalu)/height_prop)), {'id': value.properties.edge, 'class': 'elevation-segment'});
					
					//console.log("elev: "+ value.properties.rastervalu);
					
					//console.log("elev: "+ value.properties.rastervalu +"; altura canvas px: "+ height_px +"; last pont: "+ last + "; altura proporcional: "+ height_prop + "; margin: "+margin + "; resultado: "+ (height_px-(last/height_prop)));
					position = end_point;
				}
				last = value.properties.rastervalu;
			});
		}
	
		function doImage(err, canvas) {
			var img = document.createElement('img');
			var dimensions = map.getSize();
			img.width = dimensions.x;
			img.height = dimensions.y;
			img.src = canvas.toDataURL();
			console.log(img);
			//return true;
			$("#export-block").innerHTML = '';
			$("#export-block").appendChild(img);
		}

	
	$( function() {		
		$('#texts').hide();	
	
		$("#elev-block").position({
		  at: "center bottom-15%",
		  of: "#map"
		});
		
		$("#export-block").position({
		  at: "center center",
		  of: "#map"
		});
		
		// TODO: Create a generic class for floating/draggable boxes.		
		$('#elev-block').draggable();
		$('#export-block').draggable();
		
		$('#elev-block').hide();
		$('#export-block').hide();
		
		$("#text-elevation").click(function() {
			$("#elev-block").toggle("blind", 1000);
		});	
		
		$("#text-export").click(function() {
			$("#export-block").toggle("blind", 1000);
			leafletImage(map, doImage);
		});			
				
		$("#btn-route").on('click', function(){
			$('#elev-block').hide();
			$('#map').css('cursor', 'crosshair');
			$("#hiddenRoute").val(1);
			alert("Selecione dois pontos no mapa.");
			
			if(map.hasLayer(cltRoute)) { map.removeLayer(cltRoute);	}		
			if(map.hasLayer(markerDep)) { map.removeLayer(markerDep); }
			if(map.hasLayer(markerArr)) { map.removeLayer(markerArr); }
		});
		
		
		$("#btn-about").on('click', function(){
			if($('#visualization').is(":visible")) {
				$('#visualization').hide();	
				$('#texts').toggle("drop", 2000);
				$("#btn-about").text("Voltar ao Mapa");
			}
			else {
				$('#visualization').toggle("drop", 2000);
				$('#texts').hide();
				$("#btn-about").text("Sobre o Projeto");
			}
		});
		
		map.on('click', onMapClick);
	});
	

</script>

</body>
</html>
