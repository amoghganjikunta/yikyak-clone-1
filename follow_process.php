<?php

	require_once('includes/head.php');

	if (isset($_SESSION['username'])){

		$json_received = file_get_contents('php://input');
		$decoded_json = json_decode($json_received, true);
		$poster_username = $decoded_json['poster'];

		DB::query("SELECT * FROM following WHERE follower = %s AND poster = %s",
		$_SESSION['username'], $poster_username);

		if (DB::count() > 0){
			print 'alreadyFollowed';
			exit;
		}

		DB::insert('following', array(
			'follower' => $_SESSION['username'],
			'poster' => $poster_username
		));

		print 'success';
		exit;

	} else {
		print 'notLoggedIn';
		exit;
	}
