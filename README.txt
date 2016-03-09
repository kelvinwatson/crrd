CORVALIS REUSE AND REPAIR DIRECTORY INSTALLATION AND EXECUTION GUIDE
========================================================================

CONTENTS:
- Quick Start Guide
  - Android Application
  - Web Management Interface
- Detailed Installation Instructions
- Detailed Execution Instructions

NOTE: A PDF version of this guide containing accompanying screen
captures is available. Please see README.pdf.

Below is both a quick start guide and a detailed installation guide. The
purpose of the quick start guide is to allow viewing of the current
working versions of the Android application and web management
interface. The detailed guide describes the required steps for proper
installation and deployment of all components of the project.

========================================================================
QUICK START GUIDE (VIEW WORKING VERSIONS)
========================================================================

------------------------------------------------------------------------
Install and view working version of Android application
------------------------------------------------------------------------
First, extract the bzipped tarball (crrdGroup1.tar.bz2) to obtain all of
the required project files. Note that all of our project files are
also available at our GitHub repository at
https://github.com/watsokel/CRRD.

There are several ways to install and run
the Android application. Perhaps the easiest way to run the Android
application is to email the crrdForAndroid.apk file to a physical
Android device. On the Android device, tap on the emailed file
attachment (crrdForAndroid.apk) and the Android device will
automatically install the application.

Alternatively, you can view the application at http://52.37.19.17/,
which is the deployed web version of the Android application, as
requested by the client. Because this web version is deployed using the
same code as the Android application, it is identical in appearance and
functionality to the Android version.

Finally, if you have an Android AVD (virtual device/emulator) running,
you also install the crrdForAndroid.apk file by opening the command
prompt in Windows (or terminal in Linux), and navigating to the Android
sdk platform tools in your computer (e.g. cd
C:\Users\YourName\AppData\Local\Android\sdk\platform-tools), copying the
production.apk into this folder, then entering ‘adb install
crrdForAndroid.apk’. You should see a ‘Success’ message in the
command prompt. This installs the application on your emulator. More
detailed instructions on installation of the Android AVD is found below
in the detailed guide.

------------------------------------------------------------------------
View working version of the Web Management Interface
------------------------------------------------------------------------
A working version of the web management interface is hosted at
https://web.engr.oregonstate.edu/~watsokel/crrd/wmi/index.php. It
communicates with the MySQL database hosted on the ONID server. Please
use the username ‘KWatson’ and the password ‘password’ to log in
as an administrator.

========================================================================
              DETAILED INSTALLATION INSTRUCTIONS
========================================================================

------------------------------------------------------------------------
Installing the Android application (crrdForAndroid.apk)
------------------------------------------------------------------------
Installing the AndroidAppCRRD.apk file on a physical Android device is
the simplest way to install and run the working version of the Android
application.

1. Download the bzipped tarball entitled crrdGroup1.tar.bz2, and
navigate to the directory that it was downloaded to.
2. Decompress the crrdGroup1.tar.bzip2 file by entering the
following command: tar -vxjf crrdGroup1.tar.bz2
3. Find the file called crrdForAndroid.apk, located at
crrdGroup1/android/final_apk/crrdForAndroid.apk.
4. Email this file as an attachment to an Android device.
5. In the Android device, open the email and tap on the attached
crrdForAndroid.apk. This will automatically install and run the
Android application on the device.
6. Run the application by tapping on the
installed application entitled Corvallis Reuse and Repair Directory.
Install crrdForAndroid.apk on the Android Emulator (Virtual Device)

------------------------------------------------------------------------
Install crrdForAndroid.apk on the Android Emulator (Virtual Device)
------------------------------------------------------------------------
If you would like to install and run the crrdForAndroid.apk file on an
Android emulator, you will need to have an Android virtual device
(emulator) installed. The following instructions explain how to set up
the emulator to run the apk file. [13][14] System Requirements: To run
the Android AVD, your computer must be running either Windows, Mac OS X
or Linux (e.g. Ubuntu).

1. Download and install the Android Stand-alone SDK tools:
http://developer.android.com/sdk/installing/index.html?pkg=tools
2. Unpack the downloaded SDK tool file and note the location where the
SDK tools are unpacked:
- On Windows: double click the .exe (for Windows)
- On Mac OSX: decompress the .zip
- On Linux: Unpack the .tgz
3. Launch the AVD Manager by navigating into the folder where your SDK
tools were unpacked. There are two ways to launch the AVD Manager:
- In the command line, enter android avd
- Double click the AVD Manager file.
4. Create a virtual device (e.g. Nexus 5) by clicking on “Create”. For
this application, you can choose Target Android API level 22 or 23, and
use the default settings. Click on “OK” to create the emulator.
5. Select the newly created emulator and click on “Start”.
Now that we have the Android AVD set up and running, we can install the
crrdForAndroid.apk file and run the application. Keep the Android AVD
running as you follow these next instructions.
6. Download the bzipped tarball entitled crrdGroup1.tar.bz2, and
navigate to the directory that it was downloaded to.
7. Decompress the crrdGroup1.tar.bzip2 file by entering the following
command: tar -vxjf crrdGroup1.tar.bz2
8. Find the file called crrdForAndroid.apk
(located at crrdGroup1/android/final_apk) and move it to the directory
where you installed the Android SDK tools. For example, this might be
similar to the following directory in a Windows machine:
C:\Users\KWatson\AppData\Local\Android\sdk
9. With the Android AVD still running, open the command prompt in Windows
(or Terminal in Linux or Mac OSX) and change into the directory where
you installed your SDK tools. Within the SDK tools folder, change
directory into the platform-tools folder. An example of this instruction
would be the following command:
cd C:\Users\KWatson\AppData\Local\Android\sdk\platform-tools
10. Enter: adb install crrdForAndroid.apk. You should see a result
similar to the following:

Microsoft Windows [Version 6.3.9600]
(c) 2013 Microsoft Corporation. All rights reserved.
C:\Users\KWatson>cd C:\Users\KWatson\AppData\Local\Android\sdk\
platform-tools
C:\Users\KWatson\AppData\Local\Android\sdk\platform-tools>adb install
crrdForAndroid.apk 1981 KB/s (1727834 bytes in 0.851s)
  pkg: /data/local/tmp/crrdForAndroid.apk
Success

11. You have now installed the application. You will find it in the
emulator's apps list.

------------------------------------------------------------------------
Detailed installation instructions for web management interface
(including secure login) and database
------------------------------------------------------------------------
The following are detailed instructions on how to install the web
management interface to the client’s GoDaddy hosting account. To see a
working version of the web management interface, please visit:
https://web.engr.oregonstate.edu/~watsokel/crrd/wmi/index.php and login
using the username “KWatson” and the password “password”.

------------------------------------------------------------------------
Deploying the web management interface
------------------------------------------------------------------------
1. Download the bzipped tarball entitled crrdGroup1.tar.bz2, and
navigate to the directory that it was downloaded to.
2. Decompress the crrdGroup1.tar.bzip2 file by entering the following
command: tar -vxjf crrdGroup1.tar.bz2
3. Within the resulting crrdGroup1 folder, navigate to
web_management_interface folder. Here, you will find two folders: wmi
and session_saver. The wmi folder contains all of the front and back
end code files required for deploying the web management interface to
the server of choice. The session_saver folder is required for storing
login sessions. Both of these folders are required for deploying the web
management interface. In this case, the client’s server is hosted by
GoDaddy, so the following instructions pertain to deploying the web
management interface on this particular type of account.
Alternatively, you can also obtain the required files by cloning the
GitHub repository at https://github.com/watsokel/CRRD.git and retrieving
the files inside the web_management_interface folder.
4. Uncomment line 7 on both authenticateUser.php and storeUser.php to
enable backwards compatibility for the PHP password hash API. This is
necessary since the GoDaddy host has PHP 5.3 and 5.4 installed, and the
PHP password hash API was implemented from PHP 5.5 onwards. Uncommenting
line 7 in both authenticateUser.php and storeUser.php will effectively
allow the web management interface to function as intended without any
compatibility issues. Next, we will need to enable SSH in the GoDaddy
hosting account, in order to upload the files to the GoDaddy server.
6. Log into the GoDaddy account.
7. Click on Web Hosting, then Manage, then Settings and select SSH.
8. Enter the phone number on the account and click "Enable". A GoDaddy
operations team staff member will contact you with the required PIN.
9. Once you receive the PIN, enter it and click on Verify.
10. Using an FTP program such as FileZilla or WinSCP, enter the hostname
(or IP address) of the account, port 22, username and password to log
into the server using SSH. [15] If sFTP is not possible (GoDaddy may
only support sFTP for their WordPress websites), you can also upload
your files via FTP using port 21.
11. Transfer all of the files in the web_management_interface folder
(including both the wmi and session_saver folders) onto the GoDaddy
server. All of the necessary files have now been transferred to the
GoDaddy server. Depending on the folder where you’ve transferred your
files, you should be able to access the web management interface by
navigating to it on your browser. For example, if your domain name is
your-domain-name.com and you’ve uploaded the web management interface
files to a folder called admin, you would navigate to
www.your-domain-name.com/admin or
www.your-domain-name.com/admin/index.php
The web management interface web files have been transferred to the
GoDaddy hosting server, but the installation of the web management
interface is not yet complete. This is because the database must be
populated with the required data, and files must be configured in order
to connect to the MySQL database on the GoDaddy host. Because these
configuration changes are related to set up of the database, we will
explain these steps in the following section.

------------------------------------------------------------------------
Configuring the database
------------------------------------------------------------------------
1. Log into the GoDaddy account.
2. Click on Web Hosting, then Manage, then MySQL (under Databases), then
Actions, then Details. Make a note of your database user name, database
password and database name. If you do not know your database password,
you will need to change it.
3. Click on phpMyAdmin and login using the username and password from
step 2 above, and click “Go”.
4. Click on Import and select the file called data.sql from the
extracted bzipped tarball, located in the path crrdGroup1/database.
data.sql contains all of the required business, item category and item
data for the database.

------------------------------------------------------------------------
Configure PHP files to connect to database
------------------------------------------------------------------------
Using the database username and password obtained under “Configure
database” above, modify the dbp.php file, which can be found in the
directory where you uploaded the web management interface.
This is to ensure that the PHP files of the web management interface can
connect and communicate with the database on the GoDaddy server.

========================================================================
                  DETAILED EXECUTION INSTRUCTIONS
========================================================================

------------------------------------------------------------------------
Instructions on how to use the Android application
------------------------------------------------------------------------
Use of the Android application involves a series of taps through the
item categories (for reusable items) and items to search for businesses
that accept the user’s item. If the user cannot find a business that
accepts his/her item for reuse or repair, another option is to recycle
the item. By clicking on the recycle panel on the home screen, the user
can access PDF files describing items accepted by Republic Services.

------------------------------------------------------------------------
Instructions on how to use the web management interface
------------------------------------------------------------------------
These instructions will make use of a typical use case to demonstrate
how to use the web management interface and its reuse functionalities.
Because the repair functionalities are analogous to the reuse
functionalities, but less complex due to the lack of item category for
repair items, we will focus on the reuse functionalities. We will also
show how to add and edit users.

Logging into the web management interface
------------------------------------------------------------------------
Navigate to the web management interface. A working version is available
at https://web.engr.oregonstate.edu/~watsokel/crrd/wmi/index.php.

Log in using the username “KWatson” and the password “password”
(case sensitive). After logging in, you will be redirected to main.php.

View, add, edit and delete businesses
------------------------------------------------------------------------
1. From main.php, select “View businesses” or “Edit businesses”. You can
also use the Quick Links menu on the title bar (REUSE → Businesses).
2. In the View/Edit Reuse Businesses page, you will see a table
containing all of the reuse businesses in the database. Clicking the
links in the “Items Accepted” columns allows you to view items
associated with each business
3. To demonstrate the edit functionality, we will modify a business,
then revert it back to its original state. Click on the orange edit
button beside Book Bin.
4. For illustration purposes, let’s add an “s” to the business name,
changing the name from “Book Bin” to “Book Bins”.
5. Check the checkbox beside “Dishwashers”.
6. Click on the Submit button. You should then see a notification
indicating that the changes were made successfully.
7. Click on the “Click to view items” link in the “Book Bins” business’
row to check that the changes were in fact made.
8. Now, edit “Book Bins” again, changing the name back to “Book Bin” and
unchecking “Dishwashers”.
9. We will now try to add a new business. Scroll to the “Add Business”
form beneath the reuse business’ table.
10. Complete the form with arbitrary values, and select several items.
We will be removing this business later.
11 .Click “Submit” to add the new business.
12. Check to see that the details were correctly recorded.
13. Now, let’s remove this test business. Click on “Home” in the title
bar to return to main.php.
14. Select “Remove business” under “Manage REUSE Content”.
15. Find the test business and click on the delete button to the left of
the test business name.
16. You should see a pop-up message indicating to confirm deletion.
Please make sure that you have selected the test business, then click
delete. You should see a confirmation indicating that the deletion
operation completed successfully.

View and add item category
------------------------------------------------------------------------
Unlike the steps above, the steps involving addition of an item category
should only be performed if there is a true need to add an item
category. Once item categories have been added, they cannot be deleted
without logging into the MySQL database. This is a security feature to
prevent accidental deletion of item categories and resulting
catastrophic effects to the database. For illustration purposes, we will
add a test category to demonstrate functionality, but we will
subsequently remove it manually from the database.

1. From main.php, select “View item categories.”. You can also use the
“Quick Links” in the title bar (REUSE → Item Categories). You should see
a list of categories with a “view” button beside each category.
2. Click on a “view button to view the items within each category.
3. Let’s add a test category. Scroll down to the “Add Reuse Category”
form and add a new category.
4. After submitting, you should see a success message, as well as the
new category added to the table.

View and add item
------------------------------------------------------------------------
Similar to item categories, once an item has been added, it cannot be
deleted without logging into the MySQL database. This is a security
feature to prevent accidental deletion of items and resulting
catastrophic effects to the database. For illustration purposes, we will
add a test item to the test category in order to demonstrate
functionality, but we will subsequently remove the test item  manually
from the database.
1. From main.php, under the “Manage REUSE content” section, select
“View items”. You should see a table containing the reuse items, along
with their corresponding categories
2. For illustration purposes only, we will add a test reuse item to the
test reuse category we added above.
3. After adding the item, you should see a confirmation message, and the
new item added to the table.

View and add user
------------------------------------------------------------------------
1. From main.php, click on “View users” under “Manage USERS”, or use the
“Quick Links” (USERS → users). You should see a table containing all
current administrators (Fig. 57).
2. Since we are logged in as an administrator (and not a super user), we
cannot see the super user’s credentials.
3. Let’s add a user. Complete the new user form. Any fields with
whitespace will be rejected.
4. We will now edit the test user. Click on the orange button next to
the TestUser’s credentials.
5. The “Edit Existing User” form should automatically populate with the
current credentials. Enter a new password, make a note of the new
password, and click on “Confirm Edit”.
6. When the credentials have been edited and submitted (and does not
contain whitespaces), a confirmation message appears, and the user’s
credentials are modified in the database.
