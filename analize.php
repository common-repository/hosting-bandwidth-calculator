<?php
	/* 
    Plugin Name: Hosting Bandwidth Calculator
    Plugin URI: 
    Description: Performs a calculation to see how much monthly hosting bandwidth is need.
    Author: Cam Secore
    Version: 1.0 
    Author URI: http://www.reviewpon.com/
    */  

	if(isset($_POST['url'])){
		wpsa_ajax_action(trim($_POST['url']));
	}
	
	function wpsa_ajax_action($WebPage){
		include 'analizer.php';
		$pageSize = Analizer::Analize($WebPage);
		echo $pageSize;
	}
	
	function wpsa_showForm(){
		$pluginUrl = plugins_url() . '/bandwidthcalculator';
		wp_enqueue_script(
			'spinner',
			$pluginUrl . '/js/jquery.spinner.js',
			array( 'jquery' )
		);
		wp_enqueue_script(
			'app',
			$pluginUrl . '/js/app.js',
			array( 'jquery' )
		);
		include('form.php');
	}
?>