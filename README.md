## Project To-Do List
1. Retrieve more than 100 records by making multiple API requests and combining the results.
2. Handle form submission errors on the frontend.

## API Endpoints

- Jobs: `http://localhost/dev/wp-json/wp/v2/jl-jobs`
- Categories: `http://localhost/dev/wp-json/wp/v2/jl-categories`
- Locations: `http://localhost/dev/wp-json/wp/v2/jl-locations`
- Types: `http://localhost/dev/wp-json/wp/v2/jl-types`
- Experience Levels: `http://localhost/dev/wp-json/wp/v2/jl-experience-levels`

## Add dummy content using FakerPress
To make custom post types and custom taxonomies available to FakerPress, set `"public" => true`

## Authentication for the React App
We utilize the *Application Passwords* feature of WordPress to authenticate our React application, thereby enabling it to make POST requests to the WP REST API.

Please note that *Application Passwords* requires an SSL/HTTPS connection by default for enhanced security.

If you're working in a development environment without SSL/HTTPS and need to test the functionality, you can override the default requirement by adding the following code to your theme's `functions.php` file:

`add_filter( 'wp_is_application_passwords_available', '__return_false' );`

## Temporary
Since ACF uses core WP REST API endpoints, it uses core authentication methods (cookies and nonces) by default. This means that if you are building something in the WordPress dashboard, the code will be run in an already logged-in session, and no specific authentication is needed.

Should you wish to build something using the REST API endpoints outside a logged-in session (for example a JavaScript application powered by the REST API), you will need to authenticate for any POST requests. There are a number of ways to handle this authentication, including Application Passwords (available in WordPress core) the OAuth 1.0a Server plugin or the JSON Web Tokens plugin.
