<?php
/* Copyright (C) 2006 Technikum-Wien
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, USA.
 *
 * Authors: Christian Paminger 	< christian.paminger@technikum-wien.at >
 *          Andreas Oesterreicher 	< andreas.oesterreicher@technikum-wien.at >
 *          Rudolf Hangl 		< rudolf.hangl@technikum-wien.at >
 *          Gerald Simane-Sequens 	< gerald.simane-sequens@technikum-wien.at >
 */
 
require_once('../../config/vilesci.config.inc.php');
require_once('../../include/functions.inc.php');
require_once('../../include/studiengang.class.php');
require_once('../../include/benutzerberechtigung.class.php');

if (!$db = new basis_db())
	die('Es konnte keine Verbindung zum Server aufgebaut werden.');
			
$user = get_uid();

$rechte = new benutzerberechtigung();
$rechte->getBerechtigungen($user);

if(!$rechte->isBerechtigt('admin'))
	die('Sie haben keine Berechtigung für diese Seite');

$htmlstr = "";
	
if(isset($_GET['searchstr']))
	$searchstr = $_GET['searchstr'];
else 
	$searchstr = '';
	
$htmlstr.='
<form accept-charset="UTF-8" name="search" method="GET">
		Bitte Suchbegriff eingeben: 
		<input type="text" name="searchstr" size="30" value="'.$searchstr.'">
		<input type="submit" value="Suchen">
	</form>';	

if(isset($_GET['searchstr']))
{
	$sql_query = 'SELECT * FROM public.vw_betriebsmittelperson ';
	if(!empty($searchstr))
		$sql_query.=" where uid  ~* '".addslashes($searchstr)."'   OR nummer  ~* '".addslashes($searchstr)."' OR nummerintern  ~* '".addslashes($searchstr)."'  OR nachname  ~* '".addslashes($searchstr)."'  OR vorname  ~* '".addslashes($searchstr)."'  "; 
	$sql_query.="	ORDER BY nummer ";
	if(empty($searchstr))
		$sql_query.=" LIMIT 100 ";

    if(!$erg=$db->db_query($sql_query))
	{
		$htmlstr='Fehler beim Laden der Berechtigungen';
	}
	else
	{
		$htmlstr .= "<table id='t1' class='liste table-autosort:2 table-stripeclass:alternate table-autostripe'>   <thead><tr class='liste'>\n";
    	$htmlstr .= "       <th class='table-sortable:default'>Typ</th><th class='table-sortable:default'>Nummer</th>
    						<th class='table-sortable:default'>NrIntern</th><th class='table-sortable:default'>Person (UID)</th>
    						<th class='table-sortable:default'>Ausgabe</th><th class='table-sortable:alphanumeric'>Retour</th>";
    	$htmlstr .= "   </tr></thead><tbody>\n";
    	$i = 0;
    	
		while($row=$db->db_fetch_object($erg))
		{
			$htmlstr .= "   <tr>\n";
		    $htmlstr .= "       <td>".$row->betriebsmitteltyp."</td>\n";
			$htmlstr .= '       <td>
									<a href="betriebsmittel_details.php?betriebsmittel_id='.$row->betriebsmittel_id.'&person_id='.$row->person_id.'" 
										target="betriebsmittel_details">'.$row->nummer."</a></td>\n";
			$htmlstr .= "       <td>".$row->nummerintern."</td>\n";
			$htmlstr .= "       <td>$row->nachname $row->vorname &nbsp; ( $row->uid )</td>\n";
	    	$htmlstr .= "       <td>".$row->ausgegebenam."</td>\n";
			$htmlstr .= "       <td>$row->retouram</td>\n";
	    	$htmlstr .= "   </tr>\n";
	    	$i++;
		}
	    $htmlstr .= "</tbody></table>\n";
	}
}	
?>
<html>
<head>
<title>Betriebsmittel-Uebersicht</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="../../skin/vilesci.css" type="text/css">
<link rel="stylesheet" href="../../include/js/tablesort/table.css" type="text/css">
<script src="../../include/js/tablesort/table.js" type="text/javascript"></script>
<script type="text/javascript">
<!--
	document.getElementById('bmsuche').focus();
//-->
</script>
</head>

<body class="background_main">
<h2>Betriebsmittel &Uuml;bersicht</h2>

<?php
    echo $htmlstr;
?>

</body>
</html>
