# Candidate Development Test
# The problem
In order to add some new and exciting products to the site, we need to process a CSV file
from a supplier.</br >
This file contains product information which we need to extract and insert into a database
table.</br >
In addition, we need to apply some simple business rules to the data we import. A table
already exists to receive this information, but the table needs some tweaks in order to work
correctly with this file.</br >
# The Solution
You need to create a mechanism which will read the CSV file, parse the contents and then insert
the data into a MySQL database table.</br >
The import process will be run from the command line and when it completes it needs to
report how many items were processed, how many were successful, and how many were
skipped. See the import rules below.</br >
# Objectives
Your solution must be OO, based on Symfony 2 and use MySQL. Code should be clearly laid out, well commented
and covered by unit tests.</br >
Any SQL used to alter the table should be included as migration scripts with the submission.
Using a command line argument the script can be run in &#39;test&#39; mode. This will perform
everything the normal import does, but not insert the data into the database.
The supplier provides a stock level and price which we currently do not store. Using
suitable data types, add two columns to the table to capture this information.</br >
# Import Rules
Any stock item which costs less that $5 and has less than 10 stock will not be imported.</br >
Any stock items which cost over $1000 will not be imported.</br >
Any stock item marked as discontinued will be imported, but will have the discontinued
date set as the current date.</br >
Any items which fail to be inserted correctly need to be listed in a report at the end of the
import process.
# Hints
Look for existing solutions/libraries that could help organize the import code and all the rules in a nice OO program.
# Additional Considerations
Because the data is from an external source, it may present certain issues.</br >
These include:</br >
1. Whether the data is correctly formatted for CSV</br >
2. Whether the data is correctly formatted for use with a database</br >
3. Potential data encoding issues or line termination problems</br >
4. Manual interference with the file which may invalidate some entries</br >
Either address these concerns in the code or indicate in your response how you would
tackle these issues if you had more time to develop your script.
