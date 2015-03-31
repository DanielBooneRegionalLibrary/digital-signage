<?php

// read contents of slides folder
// pass them to an array to be used in javascript
if ($handle = opendir('slides')) {
    $slides = array();
    while (false !== ($entry = readdir($handle))) {
        if ( $entry != "." && $entry != ".." && $entry != ".gitignore" ){
            array_push($slides, $entry);
        }
    }
    closedir($handle);
}
?>


<!DOCTYPE html>
<html>
    <head>
        <meta name="robots" content="noindex, nofollow" charset="UTF-8">
        <title>DBRL Digital Signage</title>
        <style type="text/css">
            img {max-width: 100%; margin-left: auto; margin-right: auto; } 
            body {margin: auto; overflow: hidden; background: #010101; }
            h1 {color: #fff; }
        </style>
    </head>
    <body id="page">
        <img id="replace" src="slides/<?php echo $slides[0]; ?>" >
        <img id="next" style="display: none; " src="slides/<?php echo $slides[1]; ?>" >
        
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript">
    jQuery(document).ready(function($){
        var slideURL = "/slides/",
            slides = [],
            slideCounter = 0,
            slideTimer;

        //insert file names here
        <?php 
        for ($i = 0; $i < count($slides); $i++){
            echo "slides.push(\"$slides[$i]\");";
        }
        ?>
        //console.log(numberOfSlides);
        
        
        // set times here
        var refreshInterval = 3600000, // one hour
            slideChangeInterval = 15000,
            numberOfSlides = slides.length,
            slideCycles = Math.ceil( refreshInterval / (numberOfSlides * slideChangeInterval) ),
            refreshCountdown = slideCycles * numberOfSlides;
        //console.log(slideCycles);
        
        function changeSlide(){
            if (slideCounter >= numberOfSlides - 1){
                slideCounter = 0;
            } else {
                slideCounter++;
            }
            //console.log(slideCounter);
            
            refreshCountdown--;
            //console.log(refreshCountdown);
            if (refreshCountdown <= 0){
                location.reload();
            } else {
                $("#replace").replaceWith("<img id=\"replace\" src=\"slides/" + slides[slideCounter] + "\">");
                if (slideCounter < numberOfSlides - 1){
                    $("#next").replaceWith("<img id=\"next\" style=\"display: none; \" src=\"slides/" + slides[slideCounter + 1] + "\">"); 
                } else {
                    $("#next").replaceWith("<img id=\"next\" style=\"display: none; \" src=\"slides/" + slides[0] + "\">");
                }
            }
        }

        setInterval(function(){
            changeSlide();
        }, slideChangeInterval);

    });
    </script>
</html>