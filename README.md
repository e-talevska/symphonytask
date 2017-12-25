Quick Bet Online - Test project for Symphony Solutions
============================

This project is an online tool for converting betting odds. It's created as custom framework using symfony and laraval packages, HTML5, CSS3, JavaScript, Bootstrap, jQuery, PHP and MySQL.

Installation
------------

    git clone https://github.com/e-talevska/symphonytask.git
    cd symphonytask
    composer install
    mv config/database.sample.php config/datbase.php
    //change the required settings in config/datbase.php
    
    //run the migrations in order to create the tables
    php vendor/bin/phinx migrate -c config-phinx.php
    //run the seed in order to add sample data to odds table
    php vendor/bin/phinx seed:run -c config-phinx.php

    //the root file is web/index.php
