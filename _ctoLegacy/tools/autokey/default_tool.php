<?
defined('_JEXEC') or die('Restricted access');
$pfad = dirname(__FILE__);
$relpfad = JURI::base(true) . '/' . 'modules' . '/' . $CTOPluginName;


$lang_encode=JTEXT::_('ENCRYPT');
$lang_decode=JTEXT::_('DECRYPT');
$lang_plaintext=JTEXT::_('PLAINTEXT');
$lang_ciphertext=JTEXT::_('CIPHERTEXT');
$lang_key=JTEXT::_('KEY');
$lang_step=JTEXT::_('STEP');


global $ks_hilf, $alfa;
//global $alphabet, $search, $replace, $verteilung, $satzname;
$ks_hilf[pfad]=dirname(__FILE__);



$orgtxt=$_POST[orgtxt];
$codtxt=$_POST[codtxt];
$key=$_POST[key];
$suche=$_POST[suche];
$suchen=$_POST[suchen];
$merken=$_POST[merken];

$firsttime=FALSE;

if ($orgtxt=="" && !isset($_POST['decode']))
{
	$orgtxt=JTEXT::_('DEFAULTTEXT');
	$key="CODE";
	$firsttime=TRUE;
}


if (!function_exists("normalisiere"))
{
     #require "dll_globals_on.php";
     require "alfa_dat.php";
     require "fkt_coder.php";
     require "fkt_decipher.php";
}
$spacing=5;
$orgtxt=strtoupper(normalisiere($orgtxt,$alfa));
$codtxt=strtoupper(normalisiere($codtxt,$alfa));
$key=strtoupper(normalisiere($key,$alfa));




if ($key=="") $key="CODE";



if (isset($_POST['decode']))
{
	           $sel1="SELECTED"; 
             $orgtxt=dekAutokey($codtxt,$key,$alfa);
}

if (isset($_POST['encode']) || (!isset($_POST['decode']) && !isset($_POST['encode']) && $firsttime==TRUE))
{
                       $sel2="SELECTED"; 
                       $codtxt=kodAutokey($orgtxt,$key,$alfa);
}


if($sel1){$sObj0 = "=>";}else{$sObj0 = "&nbsp;&nbsp;";}
if($sel2){$sObj1 = "=>";}else{$sObj1 = "&nbsp;&nbsp;";}
if($sel0){$sObj2 = "=>";}else{$sObj2 = "&nbsp;&nbsp;";}
if($merken){$sObj3 = "checked";}else{$sObj3 = "";}

$inhalt.='
<form name=formular method=post>
<input type=hidden name=action value=yes>
<input type=hidden name=topic value='.$topic.'>
<table border=0>
 <tr>
  <td>
   {-orgtext-}:<br>
   <textarea name=orgtxt class="ctoformcss-txtinput-style ctoformcss-default-input-size" onKeyUp="this.value=this.value.toUpperCase()">'.spacing(strtoupper($orgtxt),$spacing).'</textarea>
  </td>
  <td valign=middle></td>
 </tr>
 <tr>
  <td>
   {-codtext-}:<br>
   <textarea name=codtxt class="ctoformcss-txtinput-style ctoformcss-default-input-size" onKeyUp="this.value=this.value.toUpperCase()">'.spacing(strtoupper($codtxt),$spacing).'</textarea>
  </td>
  <td valign=middle></td>
 </tr>
 <tr>
  <td COLSPAN=2>
   {-keyword-}:<br><input name=key value="'.strtoupper($key).'" class="ctoformcss-txtinput-style ctoformcss-autokey-keylengt">
  </td>
 </tr>
  <tr>
  <td COLSPAN=2>
<input type="submit" name="encode" value="{-encrypt-}" class="ctoformcss-default-button-m"> &nbsp;&nbsp;
<input type="submit" name="decode" value="{-decrypt-}" class="ctoformcss-default-button-m">  
  </td>
 </tr>
 
 
</table>
</form>';


$inhalt = str_replace('{-orgtext-}', $lang_plaintext, $inhalt);
$inhalt = str_replace('{-codtext-}', $lang_ciphertext, $inhalt);
$inhalt = str_replace('{-encrypt-}', $lang_encode, $inhalt);
$inhalt = str_replace('{-decrypt-}', $lang_decode, $inhalt);
$inhalt = str_replace('{-keyword-}', $lang_key, $inhalt);

echo $inhalt;
