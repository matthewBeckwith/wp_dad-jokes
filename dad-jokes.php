<?php
/*
Plugin Name: Dad Jokes
Plugin URI: https://github.com/matthewBeckwith/wp_dad-jokes
Description: Pulls a random dad joke to display on the admin side
Version: 1.0
Author: Matthew Beckwith
Author URI: http://matthewbeckwith.epizy.com/
License: GPLv2 or later
Text Domain: dadjokes
*/

add_action( 'wp_dashboard_setup', 'dj_dashboard_add_custom_widget' );

function dj_dashboard_add_custom_widget() {
	wp_add_dashboard_widget( 'dj_dashboard_widget', 'Random Dad Joke', 'dj_get_random_joke' );
}

function dj_get_random_joke() {
    $args = array( 'headers' => array("Accept" => "application/json"));
    $url = "https://icanhazdadjoke.com/";
    $res = wp_remote_get($url, $args);

    if(is_wp_error($res)){
        return false;
    }

    $body = wp_remote_retrieve_body($res);
    $data = json_decode($body);

    if(!empty($data)){
        echo('<div class="container" style="min-height:80px;">' . $data->joke . '</div><br /><a href="https://icanhazdadjoke.com/j/' . $data->id . '" class="button button-primary">GO</a>');
    }else{
        echo("...it's not funny...  there's no joke.");
    }
}