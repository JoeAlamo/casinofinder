# Casino Finder

Casino Finder allows users to view casinos on a map, as well as finding the nearest casino to their location (based either on geolocation or a provided address). 
A CRUD backend is included, and as an administrator you are able to add/edit/delete casinos, along with their location and opening times.

![Casino Finder Homepage](http://i.imgur.com/dlrruns.png)

## Justification of technological and design choices

### Using a framework, and which one

Laravel 5.2 was used as a framework for the application. 
This was chosen partly for the learning experience; I have previously mainly used Laravel 4.2 so I took the chance to learn the latest edition of the framework.
It was also chosen to reduce the amount of boiler plate code required, allowing the development of the core features from the start.
I did consider using Silex, a more barebones framework, but the scaffolding provided already by Laravel such as the Eloquent ORM and authentication system ensured efficient development.

### Architecture / Technologies

The application follows the general MVC structure. Requests map to routes, which call methods on the relevant controllers. 
The controllers communicate with the model layer in order to facilitate business logic and data access. 
The model layer was divided into two main layers: validation and services. The validation layer is concerned only with validation. 
The service layer is where the bulk of business logic occurs. Due to Eloquent being an active record ORM, data access also occurs within the service layer.
Whilst this does not follow the single responsibility principle / separation of concerns, it was chosen because Casino Finder is a relatively small application. 
There was no need to overly complicate the architecture and this approach still allows for code reuse and separation of concerns. 

For the front end, the majority of pages are constructed using Blade templates with enhanced functionality provided via jQuery. 
Bootstrap 3 was chosen due to familiarity for the styling of the application and for the use of front end components.
During the development of some of the more complicated components in jQuery, I definitely felt that it would have been better to use a front end JS framework.
I don't currently have experience using a JS framework such as React, Angular, Vue etc. but it is something I am now pursuing and learning.

### Design / Implementation choices

#### Displaying casinos on a map

The Google Maps API was used for displaying the casinos on a map. After initialising the map, AJAX is used to retrieve all of the casinos from an endpoint.
For each casino, a marker is created and the casino object is associated with the marker. 
A listener is attached to each marker, so that upon clicking the marker an info window is displayed. 
Further information can be viewed, by opening a modal from the info window displaying the full details of the casino. 
This keeps a clean user interface, allowing users to view full details if they desire.

#### Finding nearest casino

The finding of the nearest casino to the user is performed in one of two ways. 

Firstly, the HTML5 Geolocation API is attempted to be used. This prompts the user to share their location with the application.
**Note:** In the latest version of Google Chrome, the Geolocation API can't be accessed unless the site is running on HTTPS. 
Therefore, in a development environment this prompt may not appear, and the fallback discussed subsequently is used.
If the Geolocation API is available and the user shares their location, the user's latitude and longitude is captured.

If the Geolocation API is not available, or the user does not share their location, a fallback is used. 
This takes the form of an address autocomplete using the Google Places API. 
The user may start typing an address, select one of the autocomplete suggestions which grants access to the latitude and longitude of that address.
The address autocompletion was also implemented when adding/editing a casino on the admin section.

With the Lat/Lng, an AJAX call is made to an endpoint responsible for finding the nearest casino.
The Vincenty formula is used to calculate the closest casino within a configurable radius. 
The Vincenty formula was chosen due to it's accuracy and numerical stability. 
Previously, the Haversine equation was attempted which is slightly faster, but would occasionally fail to find casinos within a very close distance.
This led to a poor user experience, thus the Vincenty formula was implemented instead.

Database indexes were applied on the latitude and longitude of the casino locations to improve the speed of the query.
Furthermore, to prevent unnecessary load on the database, results for specific latitude / longitudes were cached for 30 minutes.

#### Opening times

How to store and structure the opening times of the casinos was an interesting problem. 
They could have been stored as a string, but this prevents any querying whatsoever. 
It is very likely in the future that the product owners would want to restrict finding casinos to ones which are open, or to display whether the casino is open or closed currently.
One option would have been to store one row/opening time per day. This allows querying and is a relatively simple approach.
However, problems arise when storing an opening time which extends over midnight. Imagine the following:

| day |   open_time  |   close_time  |
|-----|--------------|---------------|
| 0   | 14:00:00     | 02:00:00      |
| 1   | 17:00:00     | 22:00:00      |

If the current day is 1 (Tuesday), and the time is 01:00:00, any query to detect whether the casino is open will fail.
Furthermore, this approach does not support the possibility of having multiple opening times per day.

Instead, it was chosen to store the opening times as a true representation. The above example becomes:

| day |   open_time  |   close_time  |
|-----|--------------|---------------|
| 0   | 14:00:00     | 23:59:59      |
| 1   | 00:00:00     | 02:00:00      |
| 1   | 17:00:00     | 22:00:00      |

Therefore, if the current day is 1 (Tuesday), and the time is 01:00:00 the query will succeed.
This did push some complexity to the front end, when dealing with adding/editing and showing the opening times in a user friendly format.
However on the whole, it ensures that the data is an accurate representation which allows for expandibility and confident development of future features.

## Installation guide

### Requirements

* PHP >= 5.5.9
* Composer
* MySQL
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension

### Instructions

1. Create new MySQL database to be used by the application
2. Clone the Git repository to your folder of choice
3. Make sure your web server's document root points towards the 'public' directory
4. Run 'composer install' in the same directory that composer.json resides in
5. Once complete, a .env file should be present within the root directory. If not, manually rename .env.example to .env. Edit these configuration values accordingly, specifying debug modes, app URL and database settings
6. Run 'composer dump-autoload' followed by 'php artisan migrate --seed'. This will automatically construct the database and seed it with example data.
7. Visit the web site. You may log in as an admin using the email 'admin@admin.com' and the password 'password'.
