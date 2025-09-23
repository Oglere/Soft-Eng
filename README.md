<h1> Migrate After Pulling </h1>
php artisan migrate

<h1> Always Check Your .env File </h1>

DB_CONNECTION=mysql // Replace sqlite to mysql <br>
DB_HOST=127.0.0.1 <br>
DB_PORT=3306 <br>
DB_DATABASE=test // Check db <br>
DB_USERNAME=root <br>
DB_PASSWORD= <br>

<h1> Always Remember RMC </h1> <br>
R - Routes <br>
 Route::('/', [Controller::class, 'index'])-name('index'); <br>
M - Models <br>
 use APP\MODELS\MODELNAME; <br>
C - Controller <br>
 Combine all routes and models <br>
  public function index() { <br>
      $user = ModelName::where('name' = 'Gayle')-get(); <br>
      return view('landing_page', [ <br>
          'name' => $user, <br>
      ]); <br>
 <br>
  Landing Page View: <br>
      {{ $name ?? '' }} <br>

      
