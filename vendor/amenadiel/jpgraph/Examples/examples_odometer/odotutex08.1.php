<?php
require_once('jpgraph/jpgraph.php');
require_once('jpgraph/jpgraph_odo.php');

// Create a new odometer graph (width=250, height=200 pixels)
$graph = new OdoGraph(250, 140);

// Setup a title
$graph->title->Set('An example with thick border');
$graph->title->SetFont(FF_ARIAL, FS_BOLD, 11);

// Add drop shadow for graph
$graph->SetShadow();

// Set some nonstandard colors
$color = array(205,220,205);
$graph->SetMarginColor($color);
$graph->SetColor($color);

// Now we need to create an odometer to add to the graph.
// By default the scale will be 0 to 100
$odo = new Odometer();
$odo->SetColor('white');
$odo->SetBorder('darkgreen:0.8', 5);

$odo->scale->label->SetFont(FF_ARIAL, FS_BOLD, 10);
$odo->scale->label->SetColor('brown:0.6');

// Set display value for the odometer
$odo->needle->Set(70);

// Add drop shadow for needle
$odo->needle->SetShadow();

// Add the odometer to the graph
$graph->Add($odo);

// ... and finally stroke and stream the image back to the browser
$graph->Stroke();
