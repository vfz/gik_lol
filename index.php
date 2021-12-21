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

@unlink(__DIR__."/All_resolve_without_fraction.zip");
@unlink(__DIR__."/All_resolve_with_fraction.zip");

$zip = new ZipArchive;
$filename = __DIR__."/All_resolve_without_fraction.zip";
if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
    exit("Невозможно открыть <$filename>\n");
}

$zip2 = new ZipArchive;
$filename2 = __DIR__."/All_resolve_with_fraction.zip";
if ($zip2->open($filename2, ZipArchive::CREATE)!==TRUE) {
    exit("Невозможно открыть <$filename2>\n");
}

foreach($array_resolv AS $my_resolv){
    $results_pecent_without_fraction="0";
    $results_pecent_with_fraction="0";
    $my_resolve=trim($my_resolv);
    for($i=0.01; $i<0.99; $i=$i+0.01)
    {
        $pos_start = mb_strpos($my_resolve, "x", 0);
        $my_width_set=mb_substr($my_resolve, $pos_start+1, NULL );
        $result=$my_width_set*$i;
        $results_without_fraction=number_format((float)$result, 0, '.', '');
        $results_pecent_with_fraction.="
".$result; 
        $results_pecent_without_fraction.="
".$results_without_fraction;    
    }
    $results_pecent_without_fraction.="
".$my_width_set;
        $results_pecent_with_fraction.="
".$my_width_set;

    file_put_contents('Resolve_without_fraction_'.$my_resolve.'.TXT',$results_pecent_without_fraction);
    $zip->addFile("Resolve_without_fraction_".$my_resolve.".TXT");
    file_put_contents('Resolve_with_fraction_'.$my_resolve.'.TXT',$results_pecent_with_fraction);
    $zip2->addFile("Resolve_with_fraction_".$my_resolve.".TXT");
    // echo '<a href="'.$url.'Resolve_without_fraction_'.$my_resolve.'.TXT">'.$url.'Resolve_without_fraction_'.$my_resolve.'.TXT</a><br>';
    // echo '<a href="'.$url.'Resolve_with_fraction_'.$my_resolve.'.TXT">'.$url.'Resolve_with_fraction_'.$my_resolve.'.TXT</a><br>';

}
echo '<a href="'.$url.'All_resolve_without_fraction.zip">'.$url.'All_resolve_without_fraction.zip</a><br>';
echo '<a href="'.$url.'All_resolve_with_fraction.zip">'.$url.'All_resolve_with_fraction.zip</a><br>';
echo "
</td></tr></table>";

    $zip->close();
    $zip2->close();
?>