<?php require_once('Connections/tephone.php'); ?>
<?php
mysql_query("set  names utf8");
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_tephone, $tephone);
$query_Recordset1 = "SELECT * FROM phone";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $tephone) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css">
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="bootstrap-3.3.4-dist/css/bootstrap.min.css">
<script type="text/javascript" src="bootstrap-3.3.4-dist/js/jquery.js"></script>
<script type="text/javascript" src="bootstrap-3.3.4-dist/js/bootstrap.min.js"></script>
</head>

<body >
<center>

  <table  width=90%  border="5" cellpadding="0" cellspacing="0" style="border-color:#90F">
  <tr align="left">
    <td height="111" colspan="4"><img src="logo.png" width="475" height="95"></td>
    </tr>
  <tr>
    <td width="229" height="224" align="left" valign="top"><ul id="MenuBar1" class="MenuBarVertical">
      <li><a  href="news.php">ข่าวสาร</a></li>
    <li><a href="course.php">ข้อมูลหลักสูตรการศึกษา</a></li>
      <li><a href="subject.php">วิชาเรียนแต่ละภาคการศึกษา</a></li>
    <li><a href="hroom.php">จัดการข้อมูลอาจาร์ที่ปรึกษา</a></li>
      <li><a href="phone.php">สมุดโทรศัพท์</a></li>
    </ul></td>
    <td width="760"><h2>สมุดโทรศัพท์</h2>
    <table border="0" align="center" cellpadding="10" cellspacing="0" style="border-color:#00B2EE">
      <tr bgcolor="#C1CDCD">
        <td width="300"><center>รายชื่ออาจารย์</center></td>
        <td width="200"><center>E-mail</center></td>
        <td width="200"><center>สถานที่ติดต่อ</center></td>
        <td width="220"><center>เบอร์โทรศัพท์</center></td>
        <td width="30">&nbsp;</td>
        <td width="30">&nbsp;</td>
      </tr>
      <?php do { 
	  $iLoop++;
      $bgcolor = ( ($iLoop%2)==0 )? "#FFFFF0" : "#EEEEE0" ;
	  ?>
		<tr bgcolor="<?php echo $bgcolor ;?>">
        <td><?php echo $row_Recordset1['name']; ?></td>
        <td><?php echo $row_Recordset1['email']; ?></td>
        <td><center><?php echo $row_Recordset1['address']; ?></center></td>
        <td><center><?php echo $row_Recordset1['phonenum']; ?></center></td>
        <td><button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal_edit"  value="<?php echo $row_Recordset1['num']; ?>">Edit</button>
<div class="modal fade" id="myModal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><center>สมุดโทรศัพท์</center></h4>
      </div>
      <div class="modal-body">
       
       <!-- ***********ไปดูว่าจะดึง value มาใช้ยังไง -->
<?php require_once('Connections/tephone.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE phone SET name=%s, email=%s, address=%s, phonenum=%s WHERE num=%s",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['phonenum'], "int"),
                       GetSQLValueString($_POST['num'], "int"));

  mysql_select_db($database_tephone, $tephone);
  $Result1 = mysql_query($updateSQL, $tephone) or die(mysql_error());

  $updateGoTo = "phone.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset2 = "-1";
if (isset($_GET['num'])) {
  $colname_Recordset2 = $_GET['num'];
}
mysql_select_db($database_tephone, $tephone);
$query_Recordset2 = sprintf("SELECT * FROM phone WHERE num = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $tephone) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">รายชื่ออาจารย์:</td>
      <td><input type="text" name="name" value="<?php echo htmlentities($row_Recordset2['name'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">E-mail:</td>
      <td><input type="text" name="email" value="<?php echo htmlentities($row_Recordset2['email'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">สถานที่ติดต่อ:</td>
      <td><input type="text" name="address" value="<?php echo htmlentities($row_Recordset2['address'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">เบอร์โทรศัพท์:</td>
      <td><input type="text" name="phonenum" value="<?php echo htmlentities($row_Recordset2['phonenum'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><a href="#" onclick="javascript:window.opener.location.reload(); window.close();"><input type="submit" value="Update record" /></a></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="num" value="<?php echo $row_Recordset2['num']; ?>" />
</form>
<p>&nbsp;</p>
<?php
mysql_free_result($Recordset2);
?>

       </div>
      </div>
    </div>
  </div>
</div></td>
        <td><a href="phone_delete.php?num=<?php echo $row_Recordset1['num']; ?>"><img src="button/deletebutton.png" width="59" height="37"onClick="return confirm('Do you want to delete?')"></a></td>
      </tr>
      <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
    </table>
    <center>
      <p><button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#myModal_add">
  Add</button>
<div class="modal fade" id="myModal_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">สมุดโทรศัพท์</h4>
      </div>
      <div class="modal-body">
        <?php require_once('Connections/tephone.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO phone (name, email, address, phonenum) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['phonenum'], "text"));

  mysql_select_db($database_tephone, $tephone);
  $Result1 = mysql_query($insertSQL, $tephone) or die(mysql_error());

  $insertGoTo = "phone.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>

<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">รายชื่ออาจารย์:</td>
      <td><input type="text" name="name" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">E-mail:</td>
      <td><input type="text" name="email" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">สถานที่ติดต่อ:</td>
      <td><input type="text" name="address" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">เบอร์โทรศัพท์:</td>
      <td><input type="text" name="phonenum" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><a href="#" onclick="javascript:window.opener.location.reload(); window.close();"><input type="submit" value="Insert record" /></a></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
      </div>
    </div>
  </div>
</div>
</p></center>
    <center><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
      <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>">First</a> <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>">Previous</a>
      <?php } // Show if not first page ?>
    <?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
      <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>">Next</a> <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>">Last</a>
      <?php } // Show if not last page ?>
        <p>แถวที่&nbsp;<?php echo ($startRow_Recordset1 + 1) ?> ถึง <?php echo min($startRow_Recordset1 + $maxRows_Recordset1, $totalRows_Recordset1) ?></p>
        <p>ทั้งหมด&nbsp;<?php echo $totalRows_Recordset1 ?> แถว</p>
        
      </center>
      </a></td>
    </tr>
  <tr align="left">
    <td height="30" colspan="2" bgcolor="#9900CC"><center><p>มหาวิทยาลัยสงขลานครินทร์ วิทยาเขตภูเก็ต เลขที่ 80 หมู่ 1 ถ.วิชิตสงคราม ต.กะทู้ อ.กะทู้ จ.ภูเก็ต 83120 </p></center></td>
    </tr>
</table>
</center>
<center></center>
<p>&nbsp;</p>
<p>&nbsp;</p>
<center>
<p>&nbsp;</p></center>
<center>
  <p>&nbsp;</p>
</center>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
<script type"text/javascript">
$('#myModal').on('shown.bs.modal', function () {
  $('#myInput').focus()
})
</script>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
