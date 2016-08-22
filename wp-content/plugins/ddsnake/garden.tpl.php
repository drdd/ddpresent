<?php
$output = <<<EOT
<link rel='stylesheet' id='jquery-ui-styles-css'  href='//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css?ver=4.3.1' type='text/css' media='all' />
<script type='text/javascript' src='http://noname/wp-includes/js/jquery/ui/core.min.js?ver=1.11.4'></script>
<script type='text/javascript' src='http://noname/wp-includes/js/jquery/ui/effect.min.js?ver=1.11.4'></script>
<script type='text/javascript' src='http://noname/wp-includes/js/jquery/ui/effect-highlight.min.js?ver=1.11.4'></script>
<script type='text/javascript' src='//code.jquery.com/ui/1.11.4/jquery-ui.js?ver=1.0'></script>
<script type='text/javascript' src='http://noname/wp-content/plugins/ddsnake/ocanvas-2.8.1.min.js?ver=1.0'></script>
<script type='text/javascript' src='http://noname/wp-content/plugins/ddsnake/ddgarden.js?ver=1.0'></script>
<script type='text/javascript' src='http://noname/wp-content/plugins/ddsnake/ddplants.js?ver=1.0'></script>
<script type='text/javascript' src='http://noname/wp-content/plugins/ddsnake/ddcontrols.js?ver=1.0'></script>
<script type='text/javascript' src='http://noname/wp-content/plugins/ddsnake/ddreport.js?ver=1.0'></script>
<div align="center"  id="ttt">
    <div>
        <input type="button" value="save" id="cSave">
        <input type="button" value="load" id="cLoad">
        <textarea id="tmpStore"></textarea>
        <div id="cReport">
            <div><span>Coins </span>: <span id="rCoin">0</span> | <span>OR </span>: <span id="rOr">0</span></div>
            <div id="rHarvest">
                <div>Harvest</div>

            </div>
        </div>
    </div>
    <div align="center" id="panel"></div>
    <canvas id="ddgarden"  width="500"  height="500" style="border:1px solid #000000;"></canvas>
</div>
<style>
    .dd-btn{
        margin: 2px;
        cursor: pointer;
        display: inline-block;
        width: 30px;
        height: 30px;
        border: 1px solid grey;
    }
</style>
EOT;
return $output;