<?php

require "common.php";

?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Add Responder</title>

<!-- date.js -->
<script src="<?php echo DIR_JS; ?>/date.js" type="text/javascript"></script>
<!-- jQuery -->
<script src="<?php echo DIR_JS; ?>/jquery-1.9.1.min.js" type="text/javascript"></script>
<!-- jQuery UI -->
<script src="<?php echo DIR_JQUI; ?>/jquery-ui-1.10.2.min.js" type="text/javascript"></script>

<script type="text/javascript">
$(function() {
	// If there are any selects on the page, uncomment this to make the default option gray.
	/*$("select").change(function () {
		if(//$(this).val() == "0" ||
		   $(this).val() == "") $(this).addClass("empty");
		else $(this).removeClass("empty")
	});
	$("select").change();*/
	
	$("input[type=date]").datepicker({
		yearRange: '1925:<?php echo date("Y"); ?>',
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		showOtherMonths: true,
		selectOtherMonths: true,
		onChangeMonthYear: function(year, month, inst) {
			
			var $date = inst.input,
				sDate = (inst.selectedMonth + 1) + "/" + inst.selectedDay + "/" + inst.selectedYear;
			
			sDate = new Date(sDate).toString("MM/dd/yyyy");
			
			$date.val(sDate);
			
		},
		onSelect: function(sText, inst) {
			
			console.debug(arguments);
			
			$(".ui-datepicker a").removeAttr("href");
			
			if (inst.inline) {
				
				this._updateDatepicker(inst);
				
			} else {
				console.debug(this);
				this._hideDatepicker(true, this._get(inst, 'duration'));
				
				this._lastInput = inst.input;
				
				if (typeof(inst.input[0]) != 'object')
					inst.input.select(); // restore focus
				
				this._lastInput = null;
				
			}
			
		}
	});
});
</script>

<!-- CSS Reset -->
<link href="<?php echo DIR_CSS; ?>/reset.css" rel="stylesheet" type="text/css">
<!-- Custom Styling -->
<link href="<?php echo DIR_CSS; ?>/styles.css" rel="stylesheet" type="text/css">
<!-- jQuery UI Theme -->
<link href="<?php echo DIR_JQUI; ?>/css/redmond/redmond.min.css" rel="stylesheet" type="text/css">

</head>
<body>

<div id="wrapper">
    <form action="<?php print $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="text" id="name" name="name" placeholder="Name" pattern=".{3,}" required>
        <input type="text" id="title" name="title" placeholder="Title" required>
        <textarea id="address" name="address" placeholder="Address" required></textarea>
        <input type="email" id="email" name="email" placeholder="Email" required>
        <input type="tel" id="phone" name="phone" placeholder="Phone Number">
        <input class="inline" type="date" id="duration_start" name="duration_start" placeholder="Start">
        <input class="inline" type="date" id="duration_end" name="duration_end" placeholder="End">
        <!--<select>
        	<option value="" selected>Select One...</option>
        	<option>Test</option>
        	<option>Test2</option>
        	<option>Test3</option>
        	<option>Test4</option>
        </select>-->
        <input type="reset" value="Reset"><input type="submit" value="Submit">
    </form>
</div>

</body>
</html>