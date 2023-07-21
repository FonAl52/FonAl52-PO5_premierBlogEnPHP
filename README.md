# FonAl52-PO5_premierBlogEnPHP

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/62cf356fbe4d4822b9f681645edfe3e4)](https://app.codacy.com/gh/FonAl52/FonAl52-PO5_premierBlogEnPHP?utm_source=github.com&utm_medium=referral&utm_content=FonAl52/FonAl52-PO5_premierBlogEnPHP&utm_campaign=Badge_Grade)

This repository is Allan Fontaine's fifth project for the Openclassrooms Developer PHP/Symfony certificate.

## Usage Instructions
    1. Clone this repository to your personal server folder.
    2. Start your server.
    3. Import this database (db/P05_blog.sql) on your server using phpMyAdmin or mysql 
    4. Go to http://localhost:8888/FonAl52-PO5_premierBlogEnPHP/post&home to visit the blog.

## Using Composer
This project utilizes Composer for dependency management. Make sure you have Composer installed on your system before proceeding.

### Installing Dependencies
    1. Open a command line or terminal and navigate to the root directory of this project.
    2. Run the following command to install the dependencies:

composer install

This will download and install all the required dependencies for the project.

### Updating Dependencies
If you want to update the project's dependencies in the future, run the following command in the project's root directory:

composer update

This will update the project's dependencies based on the specifications defined in the composer.json file.

### Autoload
The project is configured to use Composer's autoloader. This means you don't need to manually include class files. The autoloader will automatically load the classes when you use them in your code.

## ICLUDES DATA SETS
    1. Users accounts sample
        - Admin (connect informations : mail= P05_blog@mail03.com password= P05_blog)
        - Simple User (connect informations : mail= P05_blog@mail02.com password= P05_blog)
        - Lock User (connect informations : mail= P05_blog@mail01.com password= P05_blog)
    2. Posts sample
    3. Comments sample
    4. Category sample
