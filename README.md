# wp-wpforms-spam-filter-plugin

This php file is a barebone custom plugin to create a spam filter for the [WPForms](https://wpforms.com/).

With this solution, one does not need to mess up with any config files or themes. Words can be included in the blacklist by using the comment blacklist field in `Settings > Discussion`.

As a barebone custom plugin, it can be uploaded to Wordpress after converting it into a `.zip` file.

## Code and credits
This code is based on the great tutorial by Nikki H Stokes: [WPForms Spam Filtering Using the Comment Blacklist Field](https://thebizpixie.com/article/stop-wpforms-spam-using-comment-blacklist-field/).

It has been adapted to:
- Make it work even if there is more than one field of the type `text` or `text-area` in the form.
- Block the submission if there are URLs inside the `text` fields (as usually spam messages contain a URL but normal messages do not).

## Steps to upload the customized plugin to Wordpress
1. Create a .zip file from the .php file
2. In Wordpress, go to Plugins > Add Plugins > Upload Plugin
3. Upload the .zip file and install it
4. Activate it
5. Done

## Useful resources
- https://thebizpixie.com/article/stop-wpforms-spam-using-comment-blacklist-field/
- https://wpforms.com/developers/how-to-block-urls-inside-the-form-fields/
- https://permalinkmanager.pro/blog/how-to-add-php-snippet-to-wordpress-3-methods/
