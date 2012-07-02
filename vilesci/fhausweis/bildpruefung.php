<?php
/* Copyright (C) 2012 FH Technikum-Wien
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
 * Authors: Andreas Oesterreicher 	<andreas.oesterreicher@technikum-wien.at>
 */
/**
 * GUI zur einfachen Prüfung von Profilbildern
 */
require_once('../../config/vilesci.config.inc.php');
require_once('../../include/betriebsmittel.class.php');
require_once('../../include/benutzerberechtigung.class.php');
require_once('../../include/functions.inc.php');
require_once('../../include/mail.class.php');
require_once('../../include/benutzer.class.php');
require_once('../../include/person.class.php');
require_once('../../include/fotostatus.class.php');

$uid = get_uid();
$rechte = new benutzerberechtigung();
$rechte->getBerechtigungen($uid);

$db = new basis_db();
echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
        "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet"  href="../../skin/fhcomplete.css" type="text/css">
	<link rel="stylesheet" href="../../skin/vilesci.css" type="text/css">
	<title>Profilfoto Check</title>
</head>
<body>
<h2>Profilfoto Check</h2>
';
if(!$rechte->isBerechtigt('basis/fhausweis','suid'))
{
	die('Sie haben keine Berechtigung für diese Seite');
}
$error = false;
$person_id='';
if(isset($_POST['person_id']))
{
	$person_id=$_POST['person_id'];
	
	//Profilbild OK - Akzeptiert Status setzen
	if(isset($_POST['akzeptieren']))
	{
		$fs = new fotostatus();
		$fs->person_id=$person_id;
		$fs->fotostatus_kurzbz='akzeptiert';
		$fs->datum = date('Y-m-d');
		$fs->insertvon = $uid;
		$fs->insertamum = date('Y-m-d H:i:s');
		$fs->updatevon = $uid;
		$fs->updateamum = date('Y-m-d H:i:s');
		
		if($fs->save(true))
		{
			echo '<span class="ok">Profilbild wurde akzeptiert</span>';
		}
		else
		{
			echo '<span class="error">Fehler beim Akzeptieren:'.$fs->errormsg.'</span>';
			$error = true;
		}		
	}
	
	//Profilbild Fehlerhaft - Infomail an die Person versenden
	if(isset($_POST['fehlerhaft']))
	{
		$benutzer = new benutzer();
		$to='';
		if($benutzer->getBenutzerFromPerson($person_id))
		{
			foreach($benutzer->result as $row)
			{
				if($to!='')
					$to.',';
				$to = $row->uid.'@'.DOMAIN;
			}
		}
		//Wenn kein Benutzer gefunden wurde, ist es ein 
		if($to!='')
		{
			$person = new person();
			$person->load($person_id);
			
			$from = 'fhausweis@technikum-wien.at';
			$subject = 'Profilbild';
			if($person->geschlecht=='m')
				$text = "Sehr geehrter Herr ".$person->vorname.' '.$person->nachname.",\n\n";
			else
				$text = "Sehr geehrte Frau ".$person->vorname.' '.$person->nachname.",\n\n";
			
			$text .= "Ihr Profilbild wurde von uns geprüft und entspricht nicht den Bildkriterien.\n";
			$text .= "Die aktuellen Bildkriterien finden Sie unter folgendem Link:\n";
			$text .= "https://cis.technikum-wien.at/cms/content.php?content_id=6174\n\n";
			$text .= "Bitte Laden Sie ein entsprechendes Profilbild im CIS unter 'Mein CIS'->'Profil' hoch.\n";
			$text .= "\n";
			$text .= "Herzlichen Dank\n";
			$text .= "Fachhochschule Technikum Wien";
			
			$mail = new mail($to, $from, $subject, $text);
			if($mail->send())
			{
				echo '<span class="ok">Infomail wurde versendet an '.$to.'</span>';
			}
			else
			{
				echo '<span class="error">Fehler beim Versenden des Mails an '.$to.'</span>';
				$error = true;
			}
		}
		else
		{
			echo '<span class="error">Keine Mail Adresse gefunden</span>';
			$error = true;
		}
		
		if(!$error)
		{
			//Status setzen
			$fs = new fotostatus();
			$fs->person_id=$person_id;
			$fs->fotostatus_kurzbz='abgewiesen';
			$fs->datum = date('Y-m-d');
			$fs->insertvon = $uid;
			$fs->insertamum = date('Y-m-d H:i:s');
			$fs->updatevon = $uid;
			$fs->updateamum = date('Y-m-d H:i:s');
			
			if(!$fs->save(true))
			{
				echo '<span class="error">Fehler beim Setzen des abgewiesen Status:'.$fs->errormsg.'</span>';
				$error = true;
			}
		}
	}
	
	//BestOf Profilbilder werden gesichert
	if(isset($_POST['bestof']))
	{
		echo 'Zu BestOf hinzugefügt';
		$qry = "SELECT inhalt FROM public.tbl_akte 
				WHERE dokument_kurzbz='Lichtbil' AND person_id=".$db->db_add_param($person_id);
		if($result = $db->db_query($qry))
		{
			if($row = $db->db_fetch_object($result))
			{
				file_put_contents('bestof/'.$person_id.'.jpg',base64_decode($row->inhalt));
				//Error setzen damit die Person nochmals angezeigt wird
				$error = true;
			}
		}
	}
}

// Laden einer Person deren Profilfoto noch nicht akzeptiert wurde
$qry = "
	SELECT 
		*,
		(SELECT 1 FROM public.tbl_mitarbeiter JOIN public.tbl_benutzer ON(mitarbeiter_uid=uid) 
		 WHERE person_id=tbl_person.person_id) as mitarbeiter
	FROM 
		public.tbl_person 
		JOIN public.tbl_benutzer USING(person_id)
	WHERE 
		foto is not NULL
		AND tbl_benutzer.aktiv";
if($error==true && $person_id!='')
{
	// Wenn ein Fehler auftritt oder Bestof geklickt wird, wird die Person erneut angezeigt
	$qry.=" AND person_id=".$db->db_add_param($person_id);
}
else
{
	// Zufaellige Reihenfolge
	$qry.=" AND random() <0.01";
	
	// Keine Eintraege die bereits akzeptiert wurden
	$qry.="	AND NOT EXISTS (SELECT 1 FROM public.tbl_person_fotostatus 
					WHERE person_id=tbl_person.person_id AND fotostatus_kurzbz='akzeptiert')";

	// Keine Eintraege bei denen Abgewiesen der letzte Status ist
	$qry.="	AND 'abgewiesen' NOT IN (SELECT fotostatus_kurzbz FROM public.tbl_person_fotostatus
						WHERE person_id=tbl_person.person_id ORDER BY datum desc, person_fotostatus_id desc LIMIT 1)";
}
$qry.="	LIMIT 1";

if($result = $db->db_query($qry))
{
	if($row = $db->db_fetch_object($result))
	{
		//Anzeige des Profilbildes
		echo '
		<br><br><br>
		<center>
		<table>	
			<tr>
				<td>
				<img src="../../content/bild.php?src=person&person_id='.$row->person_id.'" height="100px" width="75px">
				</td>
				<td>&nbsp;</td>
				<td>
				Vorname: '.$db->convert_html_chars($row->vorname).'<br>
				Nachname: '.$db->convert_html_chars($row->nachname).'<br>
				'.($row->mitarbeiter=='1'?'Mitarbeiter':'Student').'
				</td>
			</tr>
		</table>';
		
		echo '<br><br>';
		echo '<form action="'.$_SERVER['PHP_SELF'].'" method="POST">';
		echo '<input type="hidden" name="person_id" value="'.$db->convert_html_chars($row->person_id).'" />';
		echo '<input type="submit" name="akzeptieren" value="Akzeptieren" /> &nbsp;&nbsp;&nbsp;';
		echo '<input type="submit" name="fehlerhaft" value="Fehlerhaft / Infomail" /> &nbsp;&nbsp;&nbsp;';
		echo '<input type="submit" name="bestof" value="BestOf" /> ';
		echo '</form>';
		echo '</center>';
	}
	else
	{
		echo 'Es sind keine ungeprüften Bilder vorhanden';
	}
}

echo '</body>
</html>';
?>