<p align="center"><img src="http://blogbook.hu/laravel_vue_image_mosaic/public/design/balaton_mosaic.png"></p>

<p align="center">
<a href="https://blogbook.hu/laravel_vue_image_mosaic/public/"> Online Fast Photo Mosaic and Collage Maker</a>

</p>

[https://blogbook.hu/laravel_vue_image_mosaic/public/](https://blogbook.hu/laravel_vue_image_mosaic/public/).

## Overview

VueJS and Laravel Multi user Mosaic Art  and 3D Project

- Create Mosaic  with a button click.
- Combine your favorite pictures to create amazing wall art.
- You can store this pictures here and You can add more pictures later.
- Impress Your Friends with a mosaic or a collage after the event.
- Impress Your Boss with a mosaic or a collage of the products of your company.


## Features
If you are Laravel and VueJs developer I think this project is interesting for you.
Don't Buy this Script If you don't know the Javascript, VueJs,  PHP 
Please first test the basic features.
It was one of my Startup idea but I don't have enough time.

You can create almost 2500px X 1500px JPG picture at normal setting.
Add photos after login, create your own photo mosaic or collage. You can upload 100 pictures.
You can edit your pictures in private mode. Nobody can see your pictures.
You can delete all pictures with one click.

The Project consists the Vue-BabylonJS 3D art sections. This is separate, experimental section from the mosaic maker
If you create a mosaic (or upload a picture in the admin section) You can randomize them in the '3D World' or the 'Falling Blocks'

## Requirements
PHP 7 (Laravel Requirements)
MySQL

## Instructions
Instructions
This is an Mosaic Art Project to create a fast dramatic effect with the pictures.

If you are Laravel and VueJs developer I think this project is interesting for you.

Don't Buy this Script If you don't know the Javascript, VueJs,  PHP !!!!

I use Javascript Image Effects to modify the pictures.
I use Vuex Store for the communication between the components.
VueJs Component: MosaicComponent,ImageComponent,ImageuploadComponent,...

I use Xampp  for the local development.
I don't have shared hosting you can use this app on localhost to creating graphic art.

/////////////////////////////////////////


login:

Admin
admin@test.com/123456

Test user:
test@test.com/123456
test2@test.com/123456

For test@test.com, test2@test.com are not allowed to change  password

/////////////////////////////////////////

.env file, Setting, Install:

//Edit protected  .env  in the root folder
//MYSQL SETTING:
// Edit the datas with your access data of your hosting or  local server

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_vue_image_mosaic
DB_USERNAME=root
DB_PASSWORD=root



//The SQL file is in the SQL folder
The best Tool is the  PHPMyAdmin.
Import the SQL files of the program from the sql folder.

////////////////////////
//Image AND File upload setting:
//.env
//You can edit the file size If you want it.

#max image size in KB t he value is in kilobytes. : 50MB
IMAGE_SIZE = 50000

///
Edit the URL of your page.

WORK_URL=http://localhost/projects/laravel5/laravel_vue_image_mosaic/public


//////////////
VueJs edit:

First Check the NPM is existing.
npm --v

If npm is missing You can download and install here:

https://nodejs.org/en/

If you want to change the Vuejs Component:
You can edit these VueJs components.

\resources\js\components\

After edit Please Run NPM:

npm install

npm run dev


#####################################################################
##.env file:
#####################################################################
APP_NAME="Free Online Fast Photo Collage Maker - 100 photos "
APP_ENV=local
APP_KEY=base64:gxcA4FtmDU7fZsmKQKagUkl+fSySKvY+MUDYerFtAmc=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_vue_image_mosaic
DB_USERNAME=root
DB_PASSWORD=root

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

#max image size in KB t he value is in kilobytes. : 50MB
IMAGE_SIZE = 50000


# URL
WORK_URL=http://localhost/projects/laravel5/laravel_vue_image_mosaic/public
#####################################################################