<?php

require_once( 'BFIGitHubPluginUploader.php' );
if ( is_admin() ) {
    new BFIGitHubPluginUpdater( __FILE__, 'aqoonkaal', "shaashadda-admin-dashboard" );
}