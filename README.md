# customers 
Repository for BigCommerce Candidate Assignment





Few Considerations ...
================
## Caching Routes:

**Remember to run the route:cache command during your project's deployment.**

Take advantage of Laravel's route cache, if application is exclusively using controller based routes.
Using the route cache will drastically decrease the amount of time it takes to register all of of the application's routes. 
Significant performance gain may be achieved in route registration, for e.g. in some cases, may even be up to 100x faster. 

To generate a route cache, just execute the route:cache Artisan command:
```
php artisan route:cache

```
After running this command, your cached routes file will be loaded on every request. Remember, if you add any new routes you will need to generate a fresh route cache. Because of this, .

You may use the route:clear command to clear the route cache:
```
php artisan route:clear
```
## Session: File based (default) session.
The session configuration file is stored at config/session.php. 
By default, Laravel is configured to use the file session driver. 
```
 'driver' => env('SESSION_DRIVER', 'file'),
```
In production applications, you may consider using the memcached or redis drivers for even faster session performance.
