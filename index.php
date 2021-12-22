<?php
@$my_width=$argv[1];
if (empty($argv[1])){
    @$my_width=htmlspecialchars($_POST['resolve']);
}

if(empty($my_width)){

    echo"
    Вставте список разрешений (по одному на каждую строчку):
    <form action='' method=POST height=100%>
        <textarea name='resolve' id='resolve'>23x33
23x38
32x44
42x58
48x66
64x88
96x132
320x240
352x240
352x240
352x288
400x240
480x576
320x480
640x240
640x360
640x480
704x240
704x288
720x400
704x480
704x576
800x480
800x600
854x480
960x540
1024x600
1024x768
1152x864
1200x600
1280x720
1280x768
1280x1024
1408x1152
1440x900
1400x1050
1440x1080
1536x960
1536x1024
1600x900
1600x1024
1600x1200
1680x1050
1920x1080
1920x1200
2048x1080
2048x1152
2048x1536
2560x1080
2560x1440
2560x1600
2560x2048
3200x1800
3200x2048
3200x2400
3440x1440
3840x2160
3840x2400
4096x2160
5120x2880
5120x4096
6400x4096
6400x4800
7680x4320
7680x4800
10240x5760
11520x6480</textarea>
        <input type=submit value='Сгенерировать файлы'>
    </form>
    ";
exit;
}
$array_resolv=explode(PHP_EOL, $my_width);
echo"<table border=0><tr><td>";
echo"
Вставте список разрешений (по одному на каждую строчку):
<form action='' method=POST height=100%>
    <textarea name='resolve' id='resolve'>".$my_width."</textarea>
    <input type=submit value='Сгенерировать файлы'>
</form>
";
echo "</td><td>";
$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

@unlink(__DIR__."/All_WIDTH_without_fraction.zip");
@unlink(__DIR__."/All_WIDTH_with_fraction.zip");
@unlink(__DIR__."/All_WIDTH_with_round.zip");
@unlink(__DIR__."/All_HEIGHT_without_fraction.zip");
@unlink(__DIR__."/All_HEIGHT_with_fraction.zip");
@unlink(__DIR__."/All_HEIGHT_with_round.zip");

$zip = new ZipArchive;
$filename = __DIR__."/All_WIDTH_without_fraction.zip";
if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
    exit("Невозможно открыть <$filename>\n");
}

$zip2 = new ZipArchive;
$filename2 = __DIR__."/All_WIDTH_with_fraction.zip";
if ($zip2->open($filename2, ZipArchive::CREATE)!==TRUE) {
    exit("Невозможно открыть <$filename2>\n");
}

$zip3 = new ZipArchive;
$filename3 = __DIR__."/All_WIDTH_with_round.zip";
if ($zip3->open($filename3, ZipArchive::CREATE)!==TRUE) {
    exit("Невозможно открыть <$filename3>\n");
}


$zip4 = new ZipArchive;
$filename4 = __DIR__."/All_HEIGHT_without_fraction.zip";
if ($zip4->open($filename4, ZipArchive::CREATE)!==TRUE) {
    exit("Невозможно открыть <$filename4>\n");
}

$zip5 = new ZipArchive;
$filename5 = __DIR__."/All_HEIGHT_with_fraction.zip";
if ($zip5->open($filename5, ZipArchive::CREATE)!==TRUE) {
    exit("Невозможно открыть <$filename5>\n");
}

$zip6 = new ZipArchive;
$filename6 = __DIR__."/All_HEIGHT_with_round.zip";
if ($zip6->open($filename6, ZipArchive::CREATE)!==TRUE) {
    exit("Невозможно открыть <$filename6>\n");
}


foreach($array_resolv AS $my_resolv){
    $results_w_pecent_without_fraction="0";
    $results_w_pecent_with_fraction="0";
    $results_w_pecent_with_round="0";

    $results_h_pecent_without_fraction="0";
    $results_h_pecent_with_fraction="0";
    $results_h_pecent_with_round="0";

    $my_resolve=trim($my_resolv);
    for($i=0.01; $i<0.99; $i=$i+0.01)
    {
        $pos_start = mb_strpos($my_resolve, "x", 0);
        $my_width_set=mb_substr($my_resolve, $pos_start+1, NULL );
        $my_height_set=mb_substr($my_resolve, 0, $pos_start );

        $result_w=$my_width_set*$i;
        if(mb_strpos($result_w, ".", 0)==0){
            $results_w_without_fraction=$result_w;
        }else{
            $results_w_without_fraction=mb_substr($result_w, 0, mb_strpos($result_w, ".", 0));//number_format((float)$result_h, 0, '.', '');
        }
        $results_w_with_round=round($result_w);

        $result_h=$my_height_set*$i;
        if(mb_strpos($result_h, ".", 0)==0){
            $results_h_without_fraction=$result_h;
        }else{
            $results_h_without_fraction=mb_substr($result_h, 0, mb_strpos($result_h, ".", 0));//number_format((float)$result_h, 0, '.', '');
        }
        $results_h_with_round=round($result_h);

        $results_w_pecent_with_fraction.="
".$result_w; 
        $results_w_pecent_without_fraction.="
".$results_w_without_fraction;
        $results_w_pecent_with_round.="
".$results_w_with_round;

        $results_h_pecent_with_fraction.="
".$result_h; 
        $results_h_pecent_without_fraction.="
".$results_h_without_fraction;
        $results_h_pecent_with_round.="
".$results_h_with_round;

    }

    $results_w_pecent_without_fraction.="
".$my_width_set;
        $results_w_pecent_with_fraction.="
".$my_width_set;
    $results_w_pecent_with_round.="
".$my_width_set;

    $results_h_pecent_without_fraction.="
".$my_height_set;
        $results_h_pecent_with_fraction.="
".$my_height_set;
    $results_h_pecent_with_round.="
".$my_height_set;


    $zip->addFromString($my_width_set.'.TXT', $results_w_pecent_without_fraction);
    $zip2->addFromString($my_width_set.'.TXT',  $results_w_pecent_with_fraction);
    $zip3->addFromString($my_width_set.'.TXT',  $results_w_pecent_with_round);

    $zip4->addFromString($my_height_set.'.TXT', $results_h_pecent_without_fraction);
    $zip5->addFromString($my_height_set.'.TXT',  $results_h_pecent_with_fraction);
    $zip6->addFromString($my_height_set.'.TXT',  $results_h_pecent_with_round);

    // file_put_contents($my_width_set.'.TXT',$results_w_pecent_without_fraction);
    // $zip->addFile("Resolve_without_fraction_".$my_resolve.".TXT");
    // file_put_contents('Resolve_with_fraction_'.$my_resolve.'.TXT',$results_w_pecent_with_fraction);
    // $zip2->addFile("Resolve_with_fraction_".$my_resolve.".TXT");
    // echo '<a href="'.$url.'Resolve_without_fraction_'.$my_resolve.'.TXT">'.$url.'Resolve_without_fraction_'.$my_resolve.'.TXT</a><br>';
    // echo '<a href="'.$url.'Resolve_with_fraction_'.$my_resolve.'.TXT">'.$url.'Resolve_with_fraction_'.$my_resolve.'.TXT</a><br>';

}
echo '<a href="'.$url.'All_WIDTH_without_fraction.zip">'.$url.'All_WIDTH_without_fraction.zip</a><br>';
echo '<a href="'.$url.'All_WIDTH_with_fraction.zip">'.$url.'All_WIDTH_with_fraction.zip</a><br>';
echo '<a href="'.$url.'All_WIDTH_with_fraction.zip">'.$url.'All_WIDTH_with_round.zip</a><br>';

echo '<a href="'.$url.'All_HEIGHT_without_fraction.zip">'.$url.'All_HEIGHT_without_fraction.zip</a><br>';
echo '<a href="'.$url.'All_HEIGHT_with_fraction.zip">'.$url.'All_HEIGHT_with_fraction.zip</a><br>';
echo '<a href="'.$url.'All_HEIGHT_with_fraction.zip">'.$url.'All_HEIGHT_with_round.zip</a><br>';
echo "
</td></tr></table>";

    $zip->close();
    $zip2->close();
    $zip3->close();
    $zip4->close();
    $zip5->close();
    $zip6->close();
?>