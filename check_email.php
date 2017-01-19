s<?php 
/*
*  This script was writed by Setec Astronomy - setec@freemail.it
*
*  This script is distributed under the GPL License
*
*  This program is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
*   GNU General Public License for more details.
*
*  http://www.gnu.org/licenses/gpl.txt
*
*/
define ('DEBUG_OK', true);

function CheckEmail($Email) 
{ 
  if (!eregi("^[\._a-zA-Z0-9-]+@[\.a-zA-Z0-9-]+\.[a-z]{2,6}$", $Email)) return 1; 
  list($Username, $Domain) = split("@",$Email); 
  if (@getmxrr($Domain, $MXHost)) return 0; 
  else 
  { 
  $f=@fsockopen($Domain, 25, $errno, $errstr, 30); 
  if($f) 
  { 
  fclose($f); 
  return 0; 
  } 
  else return 1; 
  } 
}


//the dynamic methode 

$reg = '^(\S+)@([a-z0-9-]+)(\.)([a-z]{2,4})(\.?)([a-z]{0,4})+$';
 
$email = 'cemeh1986sasdf@12andex.ru';

/*
$email_arr = explode("@" , $email); 
$host = $email_arr[1]; 

if (!getmxrr($host, $mxhostsarr)) 
{ 
echo "send isn`t possible $email "; 
exit; 
} 

getmxrr($host, $mxhostsarr, $weight); 
echo "Send possible $email  with :<br>"; 
for ($i=0; $i < count($mxhostsarr); $i++) 
{ 
echo ("$mxhostsarr[$i] = $weight[$i]<br>"); 
} 
*/
echo CheckEmail($email);	


?>

