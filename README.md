# workramp-statistic-extractor


This project extracts the Qualitative feedback from Workramp.
Workramp provides a url-based tool that generates csv file for each course, in which contains the feedback of the course.

This extract project reads all the csv files and places the contents into 2 files: one for the feedback, the other for ratings.

Here how to use it.

-------------------------

To run the extract program

1. unzip the project into a new folder (you can call the folder anything)
--- you should have 1 file in the project's root folder: "extract.php"
--- you should have 2 folders: "results", "csv_files"

2. install php (if not done)

3. to run the program:
--- go to root directory of the extractor project 
--- type: "php extract.php"


-----------------------

To get the feedback and ratings

1. Run the following URL
https://algolia.app.workramp.com/admin/academies/d3a0c036-b002-11ea-bd57-063e41907789/guide_submissions_zip

2. This should send you an email
3. Download the zip file in the email
4. Unzip the file which contains csv files
5. copy the csv files into the project folder "csv_files"
--- Delete folder contents first
6. run the extract program ("php extract.php")
7. Results folder should have 2 new files ("ratings", "feedback")

