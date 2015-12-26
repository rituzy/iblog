The Blog.

It was faster to create this blog engine with laravel than my first two trials with Grails and Play!. One can install laravel 4.1, pull the files from my repository, adjust config file and DB connection. Then by putting one command create the whole structure in database and you are welcome to enjoy your own blog(you may have to install webserver and adjust it or just type "php artisan server" from app folder) On the very beginning I used small engine from here ...and then it grew into present version with many intersting things.
Important points:
-it needs to meet laravel requirements (PHP version 5 or higher)
-now official version is 5 but this engine is of 4.1 (on starting with this site 4 was a stable version) Upgrade to 5 will take some time and patience from you(maybe more than some) but it is possible
-2 dependencies are used here: picture loading and capcha
-you will need to create administrator role by hands in you database
-web pages about crafts are created as static htm pages (simple way to use only html+css )
-Ajax where not used except 2 things
Features:
-the engine supports recursive creating of comments on comments as in LiveJournal
-the engine supports registration through VKontakte
-photos are in the private directory and it case of request to watch it the photo is copied to temp folder. It's not allowed to copy a bunch of photos
-polymorphic relations are in use with Tags and other models.
-English and Russian language support
-soft deleting used
-text search is available on both languages
-followed "fat model, skinny controller" principle

There are some open points in TODO list, but for now it is time to start and then go on :)
