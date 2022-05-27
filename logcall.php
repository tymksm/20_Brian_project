<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Police Emergnecy Service System</title>
</head>
<body bgcolor="#FFBCA3">
	<script>
		function kasumi()
		{
			var x=document.forms["frmLogCall"]["callerName"].value;
			if (x==null || x=="")
		{
			alert("Caller Name is required.");
			return false;
		}
		// may add code for validation other imputs 
		}
	</script>
	<?php require_once 'nav.php';
	?>
	<?php require_once 'db.php';
	
	$mysqli = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
	if ($mysqli->connect_errno)
	{
		die("Unable to connect to Database: ".$mysqli->connect_errno);
	}
	
	$sql = "SELECT * FROM incidenttype";
	if(!($stmt = $mysqli->prepare($sql)))
	{
		die("Command error: ".$mysqli->errno);
	}
	if (!$stmt->execute())
	{
		die("Cannot run SQL command: ".$stmt->errno);
	}
	//check any data in resultset
	if (!($resultset = $stmt->get_result())){
		die("No data in resultset: ".$stmt->errno);
	}
	
		$incidentType; //an array variable
	
	while ($row = $resultset->fetch_assoc()) {
		$incidentType[$row['incidentTypeId']] = $row['incidentTypeDesc'];
	}
	
	$stmt->close();

	
	$resultset->close();
	
	$mysqli->close();
	
	?>
	<fieldset>
	<legend>Log Call</legend>
	<form name="frmLogCall" method="post" action="Dispatch.php" onSubmit="return kasumi();">
		<table width="45%" border="center" align="center" cellpadding="5" cellspacing="5">
		<tr>
			<td width="20%" align="center">Name of Caller:</td>
			<td width="50%"><input type="text"  name="callerName" id="callerName" pattern="[a-zA-Z- ]+" placeholder="Name" oninvalid="setCustomValidity('Please enter on alphabets only. ')" onkeypress="return onlyAlphabets(event,this);"></td>
		</tr>	
		<tr>
			<td width="20%" align="center">Contact Number:</td>
			<td width="50%"><input type="tel" pattern="[6,8,9]{1}[0-9]{7}"  placeholder="Number" maxlength="8"  name="contactNo" id="contactNo" title="A number starting with 6, 8 or 9 " required> </td>	
		</tr>
		<tr>
			<td width="50%" align="center">Location:</td>
			<td width="50%"><input type="text" name="location" id="location"> </td>
		</tr>
		<tr>
		 	<td width="50%" align="center">Incident Type:</td>
			
			<td width="50%"><select name="incidentType" id="incidentType">
			
			<?php foreach($incidentType as $key=> $value) {?>
			<option value="<?php echo $key ?> " >
			<?php echo $value ?> </option>
			<?php } ?>
		</select>
		</td>
		</tr>
		<tr>
		<td width="50%" align="center">Description:</td>	
			<td width="50%"><textarea name="incidentDesc" id="IncidentDesc" cols="45" rows="5"></textarea></td>
		</tr>
			<tr>
				<td> <input type="reset" name="cancelProcess" value="Reset"></td>
				<td> <input type="submit" name="btnProcessCall" id="btnProcessCall" value="Process Call"></td>
			</tr>
		</table>
	</form>
	</fieldset>
	<script>
	function onlyAlphabets(e, t) {
            try {
                if (window.event) {
                    var charCode = window.event.keyCode;
                }
                else if (e) {
                    var charCode = e.which;
                }
                else { return true; }
                if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || charCode == 32)
                    return true;
                else
                    return false;
            }
            catch (err) {
                alert(err.Description);
            }
        }
	</script>
</body>
</html>