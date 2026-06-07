<?php
if (isset($_POST["submit"])) {
    $url = $_POST["lien"];
    $yt_dlp = __DIR__ . DIRECTORY_SEPARATOR . "yt-dlp.exe";
    $video = __DIR__ . DIRECTORY_SEPARATOR . "video.mp4";

    // احذف أي فيديو سابق
    if (file_exists($video)) unlink($video);//تبحث في القرص هل الملف video.mp4 exist ou nn si exist supprimer le video actuelle avec la fonction unlink(هي دالة في بياشبي تقوم بحدف ملف من القرص الصلب)

    // حمّل الفيديو
    $cmd = '"'.$yt_dlp.'" -o "'.$video.'" "'.$url.'"';
    passthru($cmd);

    // تحقق من الملف
    if (file_exists($video) && filesize($video) > 100000) {//filesize fonction est utuliser en php pour determiner le stokage de video.php

        // نظف المخرجات
        if (ob_get_length()/*ادا وجدت وكان لها حجم*/ ) ob_end_clean()/*امسح كل ما بداخلها*/ */;//outpout buffer نعرف ان اي كود خارج بياشبي يخزن مؤقتا في رام السرفر حتى لو بعده اشتيامال يترك له مساحة لانه يعتبره سيخزن وبهدا نضع هده الدالة لان هيدر للتعامل معها يجب ان تكون الداكرة فارغة تماما تقوم بمسحح ما في الداكرة ادا وجد
        // أرسل رؤوس التحميل
        //توجد اوامر كثيرة لاكن عادي لانه لا تخرج شيئا الى المتصفح الا ادا كان pritn ou echo entr php ou espace avaaant <php> ou code html avant php
        header("Content-Description: File Transfer");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"video.mp4\"");
        header("Content-Length: " . filesize($video));
        flush();

        // أرسل الملف
        readfile($video);//عندما لا امسح داكرة التخزين المؤقت توضع اول بايتات الاشتيامال او حجز الاشتيامال او الاسطر الفارغة او الفراغات مع الفديو وبالتالي يتسبب في عدم عمله
        // unlink($video); // اختياري

        exit;
    } else {
        echo "<p style='color:red'>❌ فشل التحميل أو الملف غير صالح.</p>";
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
       <style>
        #lien{
            height:200px;
            width:800px;
            font-size:30px;
            border-radius:30px;
        }
        #sub{
            height:100px;
            width:100px;
            background:rgba(30, 30, 230, 0.88);
            border-radius:15px;
            transition:1s;
            
        }
        #sub:hover{
            height:90px;
            width:90px;
            background:rgba(17, 143, 122, 0.88);
            transition:1s;
             box-shadow:9px 9px 9px;
        }

#res1{
    display:none;
    border:double 2px;
    height:200px;
    width:400px;
    background:red;
}
#res2{
 display:none;
     border:double 2px;
    height:200px;
    width:400px;
    background:green;
}
        </style>
        <script>
function att()
{
    document.getElementById("res1").style.display="block";
}
window.onload=function()
{
    <?php if(isset($_POST["submit"])){?>
document.getElementById("res2").style.display="block";
<?php } ?>
    }
       
</script>
    </head>
    
    <body>
        <form method="post" action="">
        <input type="text" name="lien" id="lien" placeholder="entrer le URL">
        <input id="sub" type="submit" value="🔍" name="submit" onclick="att()">
        </form>
        <div  id="res1">attendre le fichier est on cours d'instalation</div>
        <div  id="res2">le fichier est instaler bon gosteua</div>
      

    </body>
</html>