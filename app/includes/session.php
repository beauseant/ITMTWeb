<?php
    session_start();
    session_regenerate_id();
    if(!isset($_SESSION['user']))      // if there is no valid session
    {
        header("Location: index.php");
    }    
    #if (!isset($_SESSION['repoPath'])){
        include($_SERVER['DOCUMENT_ROOT'] . '/config.php');
        $_SESSION['path_downloaded'] = $path_downloaded;
        $_SESSION['path_datasets'] = $path_datasets;
        $_SESSION['path_TMmodels'] = $path_TMmodels;
        $_SESSION['path_wordlists'] = $path_wordlists;
	    $_SESSION['mallet_path']    = $mallet_path;
        $_SESSION['temporaltrainfile'] = $temporaltrainfile;
    #}



?>
