<?php 
//function to display an error class on a field with a problem
function field_error( $problem ){
	if( isset( $problem ) ){
		echo 'class="error"';
	}
}

//no close php