<?php

	/**
	 * These are the database login details
	 */

	$host = "localhost";
	$user = "root";
	$password = null;
	$database = "activities_hub";
	$users_table = "users";
	$planners_table = "planners";
	$events_table = "events";
	$rsvp_table = "rsvp_list";
	$favorited_events = "favorited_events";

	function connectDB() {
		global $host, $user, $password, $database;
		$db = mysqli_connect($host, $user, null, $database);
		if (mysqli_connect_errno()) {
			echo "Connection failed.\n".mysqli_connect_error();
			exit();
		}
		return $db;
	}
?>