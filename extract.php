<?php

/* 

The purpose here is to extract qualitative feedback and ratings made by users of workramp courses. Workramp sends us CSV files for every course. The goal is to extract the pertinent information.

The code runs through the set of CSV files sent by Workramp. It opens each CSV and parses it looking for expected text strings, and then extracts the feedback and ratings. ?It then puts the extracted content into 2 files: one for feedbac, the other for ratings.

This is the first version of this project, so be prepared for:
    - hard-coded titles that come from our WorkRamp courses
    - hard-coded parsing (comma delimited, 2 fields)

*/

$path = "./csv_files";

$results = [];

// Open each file and place all feedback and ratings in an array
if ($handle = opendir($path)) {
    while (false !== ($file = readdir($handle))) {
        if ('.' === $file) continue;
        if ('..' === $file) continue;
        // do something with the file
        if (strpos($file, ".csv") !== false)
        {       
            echo $file . "\n\r";
            $results[] = process_file($path . "/" . $file);
        }
    }
    closedir($handle);

    // use the array to create the two output files
    $date_stamp = date("Ymd_His");

    $my_file = fopen("./results/feedback_" . $date_stamp . ".csv", "w") or die("Unable to open file!");
    foreach($results as $files) {
        foreach($files[0] as $item) {
            fwrite($my_file, $item[0] . "~" . $item[1]  . "~" . $item[2]. "\r\n");
        }
    }
    fclose($my_file);

    $my_file = fopen("./results/ratings_" . $date_stamp . ".csv", "w") or die("Unable to open file!");
    foreach($results as $files) {
        foreach($files[1] as $item) {
            fwrite($my_file, $item[0] . "~" . $item[1]  . "~" . $item[2]. "\r\n");
        }
    }
    fclose($my_file);
}


/* the parsing logic assumes that for every feedback or rating
- the first line is the title of the feedback
- the second line is not interesting
- the third starts the feedback
- the fourth or more line can a continuation of the feedback, or there its blank
- the last line is blank

For example
- line 1 (title): "This course was helpful to me."
- line 2 (useless): "User Email,Answer"
- line 3 (rating): tobby.lunsford@altec.com,5
- line 4 (end of rating): (blank)

Note: the 3rd line in above example is comma delimited, which is hardcoded in the code

*/

function process_file($filename)
{
    
    $feedback = []; 
    $ratings = []; 

    $inside_feedback = 0;
    $inside_ratings = 0;
    $guide_name = "0";

    if (($h = fopen("{$filename}", "r")) !== FALSE) 
    {
        // Each line in the file is converted into an individual array that we call $data
        // The items of the array are comma separated
        while (($data = fgetcsv($h, 1000, ",")) !== FALSE) 
        {
 
            if ($inside_feedback == 2)
            {
                $inside_feedback = 1;
            }
            elseif ($inside_feedback == 1)
            {
                if ($data[0] == "")
                {
                    $inside_feedback = 0;
                }
                else 
                {
                    // this is where we get the actual feedback content
                    $feedback[] = [ $guide_name, $data[0], $data[1] ];

                }
            }
            elseif ($inside_ratings == 2)
            {
                $inside_ratings = 1;
            }
            
            elseif ($inside_ratings == 1)
            {
                if ($data[0] == "")
                {
                    $inside_ratings = 0;
                }
                else 
                {
                    // this is where we get the actual ratings content
                    $ratings[] = [ $guide_name, $data[0], $data[1] ];
                }
            }
            elseif ( (substr($data[0], 0, strlen("Guide Name: ")) == "Guide Name: ") )
            {
                $guide_name = substr($data[0], strlen("Guide Name: "));
            }

            elseif ( (substr($data[0], 0, strlen("Anything you'd like to share?")) == "Anything you'd like to share?") )
            {
                $inside_feedback = 2;
            }		
            elseif ( (substr($data[0], 0, strlen("This course was useful and met my expectations.")) == "This course was useful and met my expectations.")
                || (substr($data[0], 0, strlen("This course was helpful to me.")) == "This course was helpful to me.") )
            {
                $inside_ratings = 2;
            }		
        }

        fclose($h);

        return [$feedback, $ratings];
    }


}

?>