<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

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


Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, yet powerful, providing tools needed for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of any modern web application framework, making it a breeze to get started learning the framework.

If you're not in the mood to read, [Laracasts](https://laracasts.com) contains over 1100 video tutorials on a range of topics including Laravel, modern PHP, unit testing, JavaScript, and more. Boost the skill level of yourself and your entire team by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for helping fund on-going Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell):

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[British Software Development](https://www.britishsoftware.co)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- [UserInsights](https://userinsights.com)
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)
- [CodeBrisk](https://codebrisk.com)
- [1Forge](https://1forge.com)
- [TECPRESSO](https://tecpresso.co.jp/)
- [Runtime Converter](http://runtimeconverter.com/)
- [WebL'Agence](https://weblagence.com/)
- [Invoice Ninja](https://www.invoiceninja.com)
- [iMi digital](https://www.imi-digital.de/)
- [Earthlink](https://www.earthlink.ro/)
- [Steadfast Collective](https://steadfastcollective.com/)
- [We Are The Robots Inc.](https://watr.mx/)
- [Understand.io](https://www.understand.io/)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
