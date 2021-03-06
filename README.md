Farbesoft CheckRolePast
===================
[![Laravel 5.5](https://img.shields.io/badge/Laravel-5.3-orange.svg?style=flat-square)](http://laravel.com)
[![Source](http://img.shields.io/badge/source-farbesofts/checkrolepast-blue.svg?style=flat-square)](https://github.com/farbesofts/checkrolepast)
[![License](http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://tldrlegal.com/license/mit-license)

checkRole is a simple and lightweight library that provides developers with a useful tool when creating login restrictions in personalized schedules by users to a specific role in the system.

- Every user has a single schedule defined.

Documentation
-------------
(Comming Soon)

Quick Installation
------------------
Begin by installing the package through Composer. The best way to do this is through your terminal via Composer itself:

```
composer require farbesofts/checkrolepast
```

Configuration
-------------------------------

To publish the config file and NotAccess view, run the following:

```
php artisan vendor:publish
```
Choose the option where the library is located, in my case:
```
[2] Provider: Farbesofts\Checkrolepast\CheckrolepastServiceProvider
```

### Service Provider
- copy the following in config.app (array Providers)

```php
Farbesofts\Checkrolepast\CheckrolepastServiceProvider::class,
```

### Middleware kernel.php
- copy on App\Http\Kernel.php -> (array $routeMiddleware):
```php
'CheckRolePast' => \Farbesofts\Checkrolepast\Middleware\CheckRolePast::class,
```

### Migrations
- Migrate the models
```
php artisan make:auth
php artisan migrate
```
If you are using a library of roles and permissions, before to migrate
on config/checkrolepast.php  to change 'run-migrations' => false, and only you migrate:
```
2019_03_16_160254_create_timetables_table
```
### Header on User Model
- Copy on App\User.php Model:
```php
use Farbesofts\Checkrolepast\Models\Role;
use Farbesofts\Checkrolepast\Models\Timetable;
use Illuminate\Support\Facades\Auth;
```
### Methods on User Model
```php
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
            return  true;
        }
        return false;
    }

    public function Timetable(){
        return $this->hasOne(Timetable::class);
    }

    public function getTimetable(){
        return $this->Timetable()->where('user_id',Auth::user()->id)->first();
    }
```
### Routing with CheckRolePast Middleware
- Copy on routes\web.php: example (Role:admin)
```php
Route::get('/notaccess', function () {
    return view('notaccess');
});
Route::group(['middleware' => 'CheckRolePast:admin'], function() {
    Route::get('/home', 'HomeController@index')->name('home');
});
```





