<?php // content="text/plain; charset=utf-8"
require_once 'jpgraph/jpgraph.php';
require_once 'jpgraph/jpgraph_line.php';

$datay = array(1.23, 1.9, 1.6, 3.1, 3.4, 2.8, 2.1, 1.9);
$graph = new Graph\Graph(300, 200);
$graph->img->SetMargin(40, 40, 40, 40);
$graph->SetScale("textlin");
$graph->SetShadow();
$graph->title->Set("Example of filled line plot");
$graph->title->SetFont(FF_FONT1, FS_BOLD);
$graph->subtitle->Set("(Starting from Y=0)");

$graph->yaxis->scale->SetAutoMin(0);

$p1 = new Plot\LinePlot($datay);
$p1->SetFillColor("orange");
$p1->mark->SetType(MARK_FILLEDCIRCLE);
$p1->mark->SetFillColor("red");
$p1->mark->SetWidth(4);
$graph->Add($p1);

$graph->Stroke();
