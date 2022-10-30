# Full Stack Challenge

I have intentionally over-engineered the app to show some more aspects of advanced PHP and OOP.

As part of the development process, I created a mini-framework that utilized regex for route matching. The router
supports placeholders.

`You can start your code review from public/index.php then check App/Application, App/Router, etc. `

## HOW TO RUN

*Throughout the development process, I have only used the built-in server*

I run PHP 8 on my local development. You can try 7.4

1. Database config is in helpers/functions.php `getDbConnection()`
2. Import `migrations/up.sql` - MySQL
3. CD into the project directory and run `php -S 127.0.0.1:8080 -t public`

### Here are some takeaways

Here are some takeaways

- I use composer only for autoloading. No external dependencies
- Most of the core functions are in App/*
- The rendering of templates uses output buffering. ob_* with the extract functions to pass variables to templates.
- The Request uses automapping to extract placeholders from the URL.
- The Response class contains helper methods to render, send JSON, etc.
- The most challenging part was the generateRouteRegex inside the Router class. Testing regex is always difficult.
- The application could use some Unit testing.
- I left some to-do messages in there.
- If you want to see some of my cool frontend work, please check out https://ajizzy.com/ - complete php & laravel.
- I spent 4 hours.
