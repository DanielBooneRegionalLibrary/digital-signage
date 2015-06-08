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
        <img id="next" style="display: none; " src="slides/<?php 
		// load the first slide in the slides folder
		echo $slides[1]; ?>" >
        
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript">
    jQuery(document).ready(function($){
        var slideURL = "/slides/",
            slides = [],
            slideCounter = 0,
            slideTimer;

        <?php 
		// this pushes the PHP slides array into the jQuery slides array
        for ($i = 0; $i < count($slides); $i++){
            echo "slides.push(\"$slides[$i]\");";
        }
        ?>
        
        // this sets the times for displaying each slide, and for the page refresh which gets new slides and discards old ones
		// the refreshInterval is an approximation of how long inbetween refreshes
		// slideCycles calculates the number of times the program will have to cycle through slides so that it can refresh between the last slide and the first
		// refreshCountdown counts down the number of slides before refreshing the page
        var refreshInterval = 3600000, // one hour
            slideChangeInterval = 15000, // every 15 seconds
            numberOfSlides = slides.length,
            slideCycles = Math.ceil( refreshInterval / (numberOfSlides * slideChangeInterval) ),
            refreshCountdown = slideCycles * numberOfSlides;
        
        function changeSlide(){
			// increments the slidesCounter used below or resets it to 0 if it's longer than the slides array
            if (slideCounter >= numberOfSlides - 1){
                slideCounter = 0;
            } else {
                slideCounter++;
            }
            
            refreshCountdown--;
			
			// If it's time to refresh the page, refresh. If it's not time yet, load the next slide.
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
		
		// calls changeSlide() based on the slideChangeInterval set above
        setInterval(function(){
            changeSlide();
        }, slideChangeInterval);

    });
    </script>
</html>