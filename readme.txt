=== JobLister ===
Contributors: msofokleous
Donate link: https://www.buymeacoffee.com/msofokleous
Tags: careers page, job board, job listing, job lists, jobs
Requires at least: 5.6
Tested up to: 6.4
Stable tag: 1.0.1
Requires PHP: 7.2
License: GPL-3.0
License URI: https://www.gnu.org/licenses/gpl-3.0.en.html

JobLister is a free and open-source WordPress plugin that allows you to set up a job listing page on your WordPress website.

== Description ==

JobLister is a free and open-source WordPress plugin that allows you to set up a job listing page on your WordPress website using a simple [jbls_jobs] shortcode. The plugin is powered by React and functions as a Single-page app, providing a range of features including a search functionality, filters, an application form, and a RTL-ready design.

**[View Demo](https://joblister.msof.me/)**

= Features =

* **Free and Open Source:** Collaborate to improve JobLister with the community.
* **Single Page Application with React:** Offers lightning-fast interactions and a seamless user experience.
* **Versatile Job Listings Display:**
  * **Overview Mode:** List jobs with search and filter capabilities.
  * **Detail Mode:** View job details and apply directly.
* **Efficient Job Search and Filter Functionality:** Narrow down job searches by keywords, categories, location, type, and experience.
* **Customization Settings:** Personalize the appearance and functionality with an intuitive settings page.
* **No Account Required:** Applicants can submit job applications without the need to log in, ensuring a user-friendly and accessible process.
* **Convenient Pagination:** Navigate through job listings with ease.
* **Sharable Links:** Share job listings with others through shareable links.
* **Application Form:** Apply easily using a form protected by Google reCAPTCHA.
* **Responsive Design:** Ensures a seamless experience across all devices.
* **RTL-Ready Design:** Supports Right-to-Left languages.

== Installation ==

= Install JobLister from within WordPress =

1. Visit the 'Plugins' menu within your dashboard and select ‘Add New Plugin’.
2. Search for ‘JobLister’.
3. Install the JobLister plugin.
4. Go to ‘After installation’ below.

= Install JobLister manually =

1. Upload the ‘joblister’ folder to the `/wp-content/plugins/` directory.
2. Activate the JobLister plugin through the ‘Plugins’ menu within your dashboard.
3. Go to ‘After activation’ below.

= After installation =

1. Visit the 'Plugins' menu within your dashboard and select 'Add New Plugin'.
2. Search for 'Radio Buttons for Taxonomies'.
3. Install and activate the Radio Buttons for Taxonomies plugin, a required dependency for JobLister to function correctly.
4. Visit 'Settings > Radio Buttons for Taxonomies' within your dashboard, and select `jbls_category`, `jbls_experience_level`, `jbls_location`, and `jbls_type`. Then, save your changes.
6. [Sign up for a Google reCAPTCHA API key pair](http://www.google.com/recaptcha/admin) for your site, choosing 'reCAPTCHA v2, Invisible'. Note down the API Site Key.
7. Visit 'Jobs > Settings' within your dashboard and enter the noted reCAPTCHA API Site Key.
8. Take a few minutes to adjust the rest of the settings to your liking.
9. Insert the [jbls_jobs] shortcode on any page.
10. You're done!

== Frequently Asked Questions ==

= Can I contribute to JobLister? =

Yes, we welcome contributions. Please refer to the [Contributing](https://github.com/PictureElement/joblister#contributing) section in the GitHub repository's `README.md` file.

= Can I customize the look and feel of the JobLister plugin to match my site's design? =

Absolutely! JobLister comes with an intuitive settings page that allows you to fine-tune the appearance to seamlessly blend with your site’s design.

For experienced developers, JobLister offers enhanced flexibility: it employs Sass in accordance with the BEM methodology, facilitating extensive and systematic customization.

= What fields are included in the application form? =

The application form is designed to collect essential information from job applicants. It includes fields for the applicant's name, email address, a section for a cover letter, a resume upload option, and a consent checkbox to ensure compliance with privacy regulations.

== Screenshots ==

1. Job Listings, Search & Filters - Light Theme
2. Job Listings, Search & Filters - Dark Theme
3. Single Job Listing With Application Form - Light Theme
4. Single Job Listing With Application Form - Dark Theme
5. Successful Submission
6. Failed Submission
7. No Jobs Found After Filtering
8. No Jobs Found After Searching
9. Jobs In WP Admin
10. Edit Job In WP Admin
11. Applications In WP Admin
12. Edit Application In WP Admin
13. Settings In WP Admin

== Changelog ==

= 1.0.1 =
* Remove custom color property from .jbls-select__multi-value__label.
* Remove border style on select input control option when focused.
* Replace Twitter's original icon with 'X' icon.
* Add demo page link to readme.
* Append a trailing slash to the end of the default privacy policy URL.

= 1.0.0 =
* Initial release.
