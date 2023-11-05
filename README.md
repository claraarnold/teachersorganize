# HW6 - Functional Website

* Author: Clara Arnold
* Class: CS408
* Semester: Fall 2023

## Overview

This website is essentially a knock-off Google Drive for teachers to organize their days
with images, videos and lesson-plans per subject. They can also include different resources.

## Reflection

I started this project really early so I actually loved this whole assignment! Unfortunately,
I developed everything on localhost then pushed to Heroku and found that my images and documents
were not being displayed or found properly by Heroku. I ended up just changing everything to be links
and making this website more of an organizational tool than a storing tool. Every image and document
has to be a link before being uploaded to the website.

I used a regular expression for the video upload links which you will see documented in register_upload_handler.php.
The only thing that seemed to pose a problem was the Google security leak warning when entering a password. I
tried hashing my passwords and storing them in the database and this is working but the warning still appears.

The project was awesome and I really feel like I learned so much and got a ton of experience!

## Compiling and Using

You can create your own account but if you want to see a fully stocked up account you can login to 
my account with the following credentials:
- First name: clara
- Last name: arnold
- Username: root
- Password: root

## Sources used

- Lecture notes
- Class notes
- Class GitHub
- GeeksforGeeks
----------

