<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Links Searching PFX</title>
        <script language="javascript" type="text/javascript" src="js/jquery.min.1.8.js"></script>
        <script language="javascript" type="text/javascript" src="js/jit-yc.js"></script>
    	 <script language="javascript" type="text/javascript" src="js/hypertree.js"></script>
        
        <link rel="stylesheet" type="text/css" media="screen" href="css/hypertree.css">
        
        <script src="http://d3js.org/d3.v3.min.js"></script>
		<style type="text/css" >
            #bloc-upload{border:2px solid grey;float:left; width:550px;height:200px;border-radius:10px;padding:10px;}
            #bloc-upload:hover{border:2px solid green;background-color:#C1E2B8;cursor:pointer}
			
            #bloc-par-defaut{border:2px solid grey;float:right; width:550px;height:200px; border-radius:10px;padding:10px}
            #bloc-par-defaut:hover{border:2px solid green;background-color:#C1E2B8;cursor:pointer}
			
            #bloc-infos{border:2px solid grey; min-height:30px;border-radius:10px;padding:10px;margin-top:10px;width:1175px;display:none}
            #infos-upload{display:none;text-align:left}
            #infos-par-defaut{display:none;text-align:right}
        </style> 
        
        <style>
			.node {cursor: pointer;}
			.node circle {  fill: #fff;stroke: steelblue;stroke-width: 1.5px;}
			.node text {font: 10px sans-serif;}
			.link { fill: none; stroke: #ccc; stroke-width: 1.5px;}
			
			circle {
  fill: rgb(31, 119, 180);
  fill-opacity: .25;
  stroke: rgb(31, 119, 180);
  stroke-width: 1px;
}

.leaf circle {
  fill: #ff7f0e;
  fill-opacity: 1;
}

text {
  font: 10px sans-serif;
}
		</style>
         
    </head>
    
    <body style="width:1200px;margin:auto;font-family:Arial,sans-serif" onload="init();">
    	<a href="index.php" style="cursor:pointer; text-decoration:none">
          <h1 style="margin-bottom:0px;">
               <img src="http://www.performics.fr/images/logo/pfx.jpg"/>
               <span style="color:green">Links Searching PFX</span>
          </h1>
       </a>
       
       
       
       
        <div style="margin:0">
           <div>
                Les fichiers doivent &ecirc;tre au <b><u>format csv Windows avec s&eacute;parateur point-virgules</u></b>. <br/>
                Chaque fichier doit avoir seulement une seule colonne d'urls
           </div>
          
           <div id="bloc-upload" style="" onMouseOver="if ($('#infos-upload').is(':hidden')) {$('#bloc-infos').slideDown(); $('#infos-par-defaut').slideUp();$('#infos-upload').slideDown();} ">
                <h2 align=center>Choix 1 : Uploader vos fichiers</h2>
                <form method="post" action="index.php" enctype="multipart/form-data">
                      <input type="hidden" name="MAX_FILE_SIZE" value="15048576" />
                      <input type="hidden" name="page" value="upload"/>
                      
                      Fichier d'urls poss&eacute;dant les mots cl&eacute;s:<br/> 
                      <input type="file" name="fichier_url"/><br/><br/> 
                      
                      Fichier d'urls o&ugrave; l'on va chercher les mots cl&eacute;s:<br/>
                      <input type="file" name="fichier_sous_domaine"/><br/><br/>
                      
                      Scoring minimum: 
                        <SELECT name="score_upload" style="width:100px">
                            <OPTION VALUE='1'>100 %</OPTION>
                            <OPTION VALUE='0.9'>90 %</OPTION>
                            <OPTION VALUE='0.8'>80 %</OPTION>
                            <OPTION VALUE='0.7'>70 %</OPTION>
                            <OPTION VALUE='0.6'>60 %</OPTION>
                        </SELECT><br/>
                              
                  <input type="submit" value="Lancer le script sur vos fichiers"/ style="float:right">
                       
                </form>
           </div>
           
            <div id="bloc-par-defaut" style="" onMouseOver="if ($('#infos-par-defaut').is(':hidden')) { $('#bloc-infos').slideDown();$('#infos-upload').slideUp();$('#infos-par-defaut').slideDown();} ">
				<form method="get" action="index.php?page=sans-upload">
					<h2 align=center>Choix 2 : Utiliser les fichiers par defaut.</h2>    
					Fichier d'urls poss&eacute;dant les mots cl&eacute;s: <br/>         
					<SELECT name="fichier_crawl1" style="width:300px">
					<?php
					$dir = "upload";
					if (is_dir($dir)) {	
						if ($dh = opendir($dir)) {
							while (($file = readdir($dh)) !== false) {
								if( $file != '.' && $file != '..' && $file != '.DS_Store') {
									echo "<OPTION VALUE='$file'>" . $file . "</OPTION>" ;
								}
							}
						   closedir($dh);
						}
					}
           		?>
					</SELECT><br/><br/>
                  Fichier d'urls o&ugrave; l'on va chercher les mots cl&eacute;s: <br/>
					<SELECT name="fichier_crawl2" style="width:300px">
					<?php
					if (is_dir($dir)) {	
						if ($dh = opendir($dir)) {
							while (($file = readdir($dh)) !== false) {
								if( $file != '.' && $file != '..' && $file != '.DS_Store') {
									echo "<OPTION VALUE='$file'>" . $file . "</OPTION>" ;
								}
							}
							closedir($dh);
						}
					}
					?>
                </SELECT><br/><br/>  
                 Scoring minimum: 
                <SELECT name="score_sans_upload" style="width:100px">
                		<OPTION VALUE='1'>100 %</OPTION>
                    	<OPTION VALUE='0.9'>90 %</OPTION>
                    	<OPTION VALUE='0.8'>80 %</OPTION>
                   	<OPTION VALUE='0.7'>70 %</OPTION>
                   	<OPTION VALUE='0.6'>60 %</OPTION>
                      <OPTION VALUE='0.5'>50 %</OPTION>
                </SELECT><br/>
                 
                <input type="hidden" value="sans-upload" name="page">
                <input type="submit" value="Lancer le script sur les fichiers par defaut" style="float:right">
			</form>
		</div>
           
           
           
           <div style="clear:both"></div>
           <div id="bloc-infos" style="">
           	<div id="infos-upload" style="">
            		Uploader vos fichiers : Le script analysera les urls du fichier 1 pour en ressortir les mots clés.<br/> Une fois ces mots clés obtenus, nous les chercherons dans les urls contenues dans le fichier 2 en tenant compte du 'scoring' selectionné.
            	</div>
                
               <div id="infos-par-defaut" style="">
            		Fichiers par defaut : En l'absence de fichier à fournir vous pouvez tester le script avec 2 fichiers par defauts.<br/> Si vous avez accès au dossier du serveur, vous pouvez ajouter vos nouveaux fichiers dedans.
            	</div>
                   
           </div>
       </div>
       <div style="clear:both" ></div>
    <br/>

	
    <?php 
		require 'modele.class.php';
		ini_set("auto_detect_line_endings", true);
		ini_set('display_errors', '1');
		ini_set('max_execution_time', '1800');
		ini_set('max_input_time ', '120');
		ini_set('memory_limit ', '128M');
		ini_set('upload_max_filesize', '50M');
		ini_set('post_max_size', '50M');
		ini_set('max_input_nesting_level', '128');

    	$nb_mot_clefs = 0;
		
	if(!isset($_REQUEST['page'])){ //si il n y a pas de variable page
		echo "<div><h2>Faites votre choix</h2></div>"; 	
	}
	else
	{ //si il ya la variable page
	?>
    <div id="bloc-traitement" style="border:2px solid grey; overflow:auto;height:400px;border-radius: 5px;">
    	<img id='loader' src='images/modal_loader.gif' width=80 style='position:fixed;top:10px;left:47.2%;display:block'/>
        <!--Defilement du loader lorsqu'on effectue un traitement de fichier -->
    <?php
		if( $_REQUEST['page']=="upload"){ 
			if(isset($_FILES['fichier_url']) && isset($_FILES['fichier_sous_domaine']) && $_FILES['fichier_url']['name']!="" && $_FILES['fichier_sous_domaine']['name']!=""){ 
				$dossier = 'upload';
			   $date = date("Y-m-d_H-i-s").'_';
			   $fichier1 = basename($_FILES['fichier_url']['name']);
			   $fichier2 = basename($_FILES['fichier_sous_domaine']['name']);
			   
			   if(isset($_REQUEST['score_upload']) && is_numeric($_REQUEST['score_upload']))
						$score_upload = $_REQUEST['score_upload'];
				else
						$score_upload = 1;
           
           
				if(move_uploaded_file($_FILES['fichier_url']['tmp_name'],$dossier.DIRECTORY_SEPARATOR.$date.$fichier1 ) && move_uploaded_file($_FILES['fichier_sous_domaine']['tmp_name'], $dossier.DIRECTORY_SEPARATOR.$date.$fichier2 )){
					echo '<h2>Upload effectu&eacute; avec succ&egrave;s !</h2>';
					$error_upload = 0;
					$fichier_url=$dossier.DIRECTORY_SEPARATOR . $date. $fichier1;
					$fichier_sous_domaine=$dossier.DIRECTORY_SEPARATOR .  $date . $fichier2 ;
					
					$fichier_de_traitement = new Csv($fichier_url);
					$fichier_de_traitement->start($fichier_sous_domaine,$score_upload);
					?>
               <script>
                 $('#container').slideDown();
				</script>
               <?
					// Lancement du traitement avec fichiers uploadés
				}
           	else 
             	 echo '<h2>Echec de l\'upload !</h2>';    
        	}
			else
           	echo '<h2>Il manque au moins un fichier d\'upload</h2>';
		}
      	else if( $_REQUEST['page']=="sans-upload"){ // cas sans upload avec fichier par defaut
			if(isset($_REQUEST['fichier_crawl1']) && isset($_REQUEST['fichier_crawl2'])){
					$fichier_url=$dir.DIRECTORY_SEPARATOR.$_REQUEST['fichier_crawl1'];
					$fichier_sous_domaine=$dir.DIRECTORY_SEPARATOR.$_REQUEST['fichier_crawl2'];
					echo "<br/>fichier 1 : $fichier_url";
					echo "<br/>fichier 2 : $fichier_sous_domaine<br/>";
					
					if(isset($_REQUEST['score_sans_upload']) && is_numeric($_REQUEST['score_sans_upload']))
						$score_sans_upload = $_REQUEST['score_sans_upload'];
			}
			else{
				$fichier_url="upload". DIRECTORY_SEPARATOR ."fichier_url1.csv";
				$fichier_sous_domaine="upload". DIRECTORY_SEPARATOR ."fichier_url2.csv";
				$score_sans_upload = 1;
			}
			if (file_exists($fichier_url) && file_exists($fichier_sous_domaine)) {
				$fichier_de_traitement = new Csv($fichier_url);
				$fichier_de_traitement->start($fichier_sous_domaine,$score_sans_upload);
				$nb_mot_clefs = count($fichier_de_traitement->renvoie_mots_clefs());

				// Lancement du traitement avec fichiers par defaut
			}
			else
				echo "<h2>Il manque au moins un fichier par defaut. V&eacute;rifiez les noms de fichiers</h2>";
		}
		else // il ya une variable page mais elle correspond pas
			echo "<div><h2>Mauvaise Url : la valeur de la variable page est incorrecte</h2></div>";
	?> 
    </div>
	

   
    
   

	<h2>Graph 2 : Collapsible Tree </h2>
    <div id="graph2" style="border:1px solid grey;overflow:auto;height:500px;border-radius: 5px;">
		<script>
			var root 		= json_collapsible_tree;
			root.x0 		= height / 2;
			root.y0 = 0;
			var margin		= {top: 20, right: 120, bottom: 20, left: 120};
			var width  	= 1560 - margin.right - margin.left;
			var lignes 		= d3.layout.tree().nodes(root).reverse().length - <?php echo $nb_mot_clefs ?>;
			var height 		= Math.max((lignes* 22) - margin.top - margin.bottom,(<?php echo $nb_mot_clefs ?>* 22) - margin.top - margin.bottom); // Taille en fonction du nombre de mot clés	
			var i 			= 0;
			var duration 	= 200; // temps de l'effet js
			var diagonal 	= d3.svg.diagonal().projection(function(d) { return [d.y, d.x]; });
			var tree 		= d3.layout.tree().size([height, width]);
			var svg 		= d3.select("#graph2").append("svg")
							.attr("width", width + margin.right + margin.left)
							.attr("height", height + margin.top + margin.bottom)
							.attr("id", "collapsible_tree")
							.append("g")
							.attr("transform", "translate(" + margin.left + "," + margin.top + ")");
           
			function collapse(d) {if (d.children) {d._children = d.children;d._children.forEach(collapse);d.children = null;}}
			root.children.forEach(collapse);
			update(root);
			d3.select(self.frameElement).style("height", height);

			function update(source) {
				var nodes = tree.nodes(root).reverse();
				var links = tree.links(nodes);
				nodes.forEach(function(d) { d.y = d.depth * 180; });
				var node = svg.selectAll("g.node").data(nodes, function(d) { return d.id || (d.id = ++i); });
				var nodeEnter = node.enter().append("g")
				  .attr("class", "node")
				  .attr("transform", function(d) { return "translate(" + source.y0 + "," + source.x0 + ")"; })
				  .on("click", click);
				nodeEnter.append("circle").attr("r", 1e-6).style("fill", function(d) { return d._children ? "lightsteelblue" : "#fff"; });
				nodeEnter.append("text")
				  .attr("x", function(d) { return d.children || d._children ? -10 : 10; })
				  .attr("dy", ".35em")
				  .attr("text-anchor", function(d) { return d.children || d._children ? "end" : "start"; })
				  .text(function(d) { return d.name; })
				  .style("fill-opacity", 1e-6);
				var nodeUpdate = node.transition().duration(duration).attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; });
				nodeUpdate.select("circle").attr("r", 4.5).style("fill", function(d) { return d._children ? "lightsteelblue" : "#fff"; });
				nodeUpdate.select("text").style("fill-opacity", 1);
				var nodeExit = node.exit().transition().duration(duration).attr("transform", function(d) { return "translate(" + source.y + "," + source.x + ")"; }).remove();
				nodeExit.select("circle").attr("r", 1e-6);
				nodeExit.select("text").style("fill-opacity", 1e-6);
				var link = svg.selectAll("path.link").data(links, function(d) { return d.target.id; });
				link.enter().insert("path", "g").attr("class", "link").attr("d", function(d) {var o = {x: source.x0, y: source.y0};return diagonal({source: o, target: o});});
				link.transition().duration(duration).attr("d", diagonal);
				link.exit().transition().duration(duration).attr("d", function(d) {var o = {x: source.x, y: source.y};return diagonal({source: o, target: o});}).remove();nodes.forEach(function(d) {d.x0 = d.x;d.y0 = d.y;});
			}  
			function click(d) {if (d.children) {d._children = d.children;d.children = null;} else {d.children = d._children;d._children = null;}update(d);}
		</script>
	    <div style="clear:both"></div>
    </div>
    
    
    <div style="clear:both"></div>
    
    
    
    <h2>Graph 3 : Indented Tree </h2>
    <div id="graph3" style="border:1px solid grey;overflow:auto;height:500px;border-radius: 5px;">
		<script>
		var root2 			= json_indented_tree;
		root2.x0 			= 0;
		root2.y0 			= 0;
        var margin2 		= {top: 30, right: 20, bottom: 30, left: 20};
        var width2 		= 960 - margin2.left - margin2.right;
        var barHeight2 	= 14;
        var barWidth2 	= width2 * .8;
        var i 				= 0;
        var duration2 	= 400;
        var root2;
        var tree2 			= d3.layout.tree().nodeSize([0, 20]); 
        var diagonal2 	= d3.svg.diagonal().projection(function(d) { return [d.y, d.x]; });
        var svg2 			= d3.select("#graph3").append("svg").attr("width", width2 + margin2.left + margin2.right).attr("height", tree2.nodes(root2).length* (barHeight2) + 40).attr("id", "indented_tree").append("g").attr("transform", "translate(" + margin2.left + "," + margin2.top + ")");
		
        update2(root2);

        function update2(source) {
          var nodes = tree2.nodes(root2);
          var height2 = Math.max(50, nodes.length * barHeight2 + margin2.top + margin2.bottom );
          //d3.select("svg").transition().duration(duration2).attr("height", height2 );
          d3.select(self.frameElement).transition().duration(duration2).style("height", height2 + "px");
          nodes.forEach(function(n, i) {n.x = i * barHeight2;});
          var node = svg2.selectAll("g.node").data(nodes, function(d) { return d.id || (d.id = ++i); });
          var nodeEnter = node.enter().append("g").attr("class", "node").attr("transform", function(d) { return "translate(" + source.y0 + "," + source.x0 + ")"; }).style("opacity", 1e-6);
          nodeEnter.append("rect").attr("y", -barHeight2 / 2).attr("height", barHeight2).attr("width", barWidth2).style("fill", color).on("click", click2);
          nodeEnter.append("text").attr("dy", 3.5).attr("dx", 5.5).text(function(d) { return d.name; });
          nodeEnter.transition().duration(duration2).attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; }).style("opacity", 1);
          node.transition().duration(duration2).attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; }).style("opacity", 1).select("rect").style("fill", color);
          node.exit().transition().duration(duration2).attr("transform", function(d) { return "translate(" + source.y + "," + source.x + ")"; }).style("opacity", 1e-6).remove();
          var link = svg2.selectAll("path.link").data(tree2.links(nodes), function(d) { return d.target.id; });
          link.enter().insert("path", "g").attr("class", "link").attr("d", function(d) {var o = {x: source.x0, y: source.y0};return diagonal2({source: o, target: o});}).transition().duration(duration2).attr("d", diagonal2);
          link.transition().duration(duration2).attr("d", diagonal2);
          link.exit().transition().duration(duration2).attr("d", function(d) {var o = {x: source.x, y: source.y};return diagonal2({source: o, target: o});}).remove();
          nodes.forEach(function(d) {d.x0 = d.x;d.y0 = d.y;});
        }
        function click2(d) {if (d.children) {d._children = d.children;d.children = null;} else {d.children = d._children;d._children = null;}update2(d);}
        function color(d) {return d._children ? "#3182bd" : d.children ? "#c6dbef" : "#fd8d3c";} 
        </script>
        <div style="clear:both"></div>
    </div>
    
    <div style="clear:both"></div>
    
    <h2>Graph 4 : Circle Packing </h2>
    <div id="graph4" style="border:1px solid grey;overflow:auto;height:1050px;border-radius: 5px;">
        <script>
			var diameter4 = 1000;
			var format4 = d3.format(",d");
			var pack4 = d3.layout.pack().size([diameter4 - 4, diameter4 - 4]).value(function(d) { return d.size; });
			var svg4 = d3.select("#graph4").append("svg").attr("width", diameter4).attr("height", diameter4).append("g").attr("transform", "translate(2,2)");
			var root4 = json_circle_packing;
			var node4 = svg4.datum(root4).selectAll(".node").data(pack4.nodes).enter().append("g").attr("class", function(d) { return d.children ? "node" : "leaf node"; }).attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });
			node4.append("title").text(function(d) { return d.name + (d.children ? "" : ": " + format4(d.size)); });
			node4.append("circle").attr("r", function(d) { return d.r; });	
			node4.filter(function(d) { return !d.children; }).append("text").attr("dy", ".3em").style("text-anchor", "middle").text(function(d) { return d.name.substring(0, d.r / 3); });
			d3.select(self.frameElement).style("height", diameter4 + "px");
			</script>
        <div style="clear:both"></div>
    </div>
    
    
    	<h2>Graph 1 : Hyperbolic Tree</h2>
		<?php
		if($nb_mot_clefs < 50){
       ?>
         <div id="container" >
            <div id="center-container" >
                <div id="infovis" style="border:1px solid red"></div>    
            </div>
            <div id="right-container">
                <div id="inner-details"></div>
            </div> 
             <div id="log"></div>
        </div>
       
        <?php
        }
        else
            echo "Le nombre de mots-clés est trop élevé pour générer un graphe 'Hyperbolic Tree' lisible";
		
   
	}//Fin du traitement
	?>

    </body>
</html>
