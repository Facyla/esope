# Theme template

This plugin provides a basic template to start setting up a theme based on esope

To get started, replace all "theme_template" occurrences with your theme name. You should do this both in file structure (folders name), and inside the plugin files content.
You can use this CLI command for text replacement : find ./ -type f -exec sed -i "s#theme_template#theme_myprojectname#g" {} \;

Then customize the manifest.xml file, and this README.md file.

Now you're ready to tweak your theme !

To do so, edit or override the main files :
- start.php for hooks, events, views extensions, etc.

- views/default/theme_template/css.php for theme CSS styles

- views/default/page/elements/footer.php for footer
- views/default/page/elements/top.php for site top (user) menu
- views/default/page/elements/header.php for site banner and main navigation menu

- pages/theme_template/loggedin_homepage.php for logged in homepage
- pages/theme_template/public_homepage.php for public homepage (if no walled garden)
- views/default/page/walled_garden.php for walled garden homepage


