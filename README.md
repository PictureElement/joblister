Examples:
- https://demo.wpjobopenings.com/list-view/
- https://www.amazon.jobs/en-gb/
- https://jobs.zalando.com/en/jobs

Todo:
1. Change Apply, Submit now and social media buttons hover state
2. Style "No jobs found" and "Loading ..."
4. Retrieve more than 100 records by making multiple API requests and combine the results.
5. If there's only one page of content, hide the pagination
6. Input validation (frontend + backend)
7. Add consent checkbox
8. Add thank you message after submission

Endpoints:
http://localhost/dev/wp-json/wp/v2/jl-jobs
http://localhost/dev/wp-json/wp/v2/jl-categories
http://localhost/dev/wp-json/wp/v2/jl-locations
http://localhost/dev/wp-json/wp/v2/jl-types
http://localhost/dev/wp-json/wp/v2/jl-experience-levels

Notes:
To make custom post types and custom taxonomies available to FakerPress, set "public" => true

We utilize the "Application Passwords" feature to authenticate our React app and enable it to make POST requests to WP REST:

1. Enable SSL
2. Add `define( 'WP_ENVIRONMENT_TYPE', 'local' );` to `wp-config.php`
3. Add `add_filter( 'wp_is_application_passwords_available', '__return_true' );` to `functions.php`


Since ACF uses core WP REST API endpoints, it uses core authentication methods (cookies and nonces) by default. This means that if you are building something in the WordPress dashboard, the code will be run in an already logged-in session, and no specific authentication is needed.

Should you wish to build something using the REST API endpoints outside a logged-in session (for example a JavaScript application powered by the REST API), you will need to authenticate for any POST requests. There are a number of ways to handle this authentication, including Application Passwords (available in WordPress core) the OAuth 1.0a Server plugin or the JSON Web Tokens plugin.

The solution that has worked for me is using a incognito window. Which involves login in each time and is a real pain. But it works for me then.
