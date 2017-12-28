<?php
$defflip = (!cfip()) ? exit(header('HTTP/1.1 401 Unauthorized')) : 1;

if ($user->isAuthenticated()) {


    $aWorkers = $worker->getWorkers($_SESSION['USERDATA']['id']);

    $file   = 'mining';
    $suffix = ($_GET['os']=='win')?'bat':'sh';
    $workerNum = (isset($_GET['id']))?$_GET['id']:null;
    $fileName = $file .'.'. $suffix;

    for($i=0; $i<count($aWorkers);$i++){
      if($aWorkers[$i]['id']==$workerNum){
        $script = '-u '. $aWorkers[$i]['username']. ' -p ' . $aWorkers[$i]['password'];
        break;
      }
    }


if ($_GET['os']=='win'){
$buffer =<<< EOF
echo "#####################################"
echo "# !BitZeny!   zny.coiner.site       #"
echo "#####################################"

minerd -a yescrypt -o stratum+tcp://zny.coiner.site:19666 {$script}

pause

EOF;
} else{
$buffer =<<< EOF
echo "#####################################"
echo "# !BitZeny!   zny.coiner.site       #"
echo "#####################################"

./minerd -a yescrypt -o stratum+tcp://zny.coiner.site:19666 {$script}

pause

EOF;
}


    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($fileName).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    echo $buffer;
    exit;

}
