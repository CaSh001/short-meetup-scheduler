# Short meetup scheduler app

## Simple guide to starting up locally from scratch

1. Install PHP, Composer and Node.js
    - https://www.php.net/downloads.php
    - https://getcomposer.org/download/

2. Clone the repo
3. In your php folder, in the file `php.ini`, make sure the line `;extension=fileinfo` is uncommented, like this: `extension=fileinfo`
3. In the same file, comment out "extension=pdo_sqlite" also
3. Open a command line and navigate to the project folder
4. Run `composer install`
5. Rename the file `.env.example` to just `.env`
5. Run `php artisan key:generate`
6. Run `php artisan migrate` and create the database when asked
7. Run other migration related commands as needed
7. Run `npm install` and `npm run build`
6. Run `php artisan serve`


## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
