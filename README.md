# workramp-statistic-extractor


The purpose of this project is to extract qualitative feedback and ratings made by users of workramp courses. Workramp sends us CSV files for every course. The goal is to extract the pertinent information from each CSV.

This extract project reads all the csv files and places the contents into two files: one for the feedback, the other for ratings.

Here how to use it.

-------------------------

To run the extract program

1. clone this project
--- you should have 1 file in the project's root folder: "extract.php"
--- you should have 2 folders: "results", "csv_files"

2. install php (if not done)

3. Copy CSV files from workramp into an empty "csv_files" folder
3. run the program:
--- go to the root directory of the extractor project 
--- type: "php extract.php"

Done. Feedback and ratings are in results folder.

-----------------------

To get the feedback and ratings

1. Run the following URL
https://algolia.app.workramp.com/admin/academies/d3a0c036-b002-11ea-bd57-063e41907789/guide_submissions_zip

2. This should automatically send you an email with the CSV files

3. Download the zip file in the email

4. Unzip the file which contains csv files

5. Copy the csv files into the project folder "csv_files" (note: Delete folder contents first)

6. Run the extract program ("php extract.php")

7. The esults folder should have 2 new files ("ratings", "feedback")

