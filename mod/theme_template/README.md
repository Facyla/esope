# Theme template

This plugin provides a basic template to start setting up a theme based on esope

To get started, replace all "theme_template" occurrences with your theme name, which should start by "theme_", e.g. "theme_myprojectname". You should do this both in file structure, and inside the theme plugin files content (so choose carefully).

Then customize the manifest file.

Now you're done and can tweak your theme !

To do so, edit the main files :
- views/default/theme_template/css.php for theme CSS styles

- views/default/page/elements/footer.php for footer
- views/default/adf_public_platform/adf_header.php for site banner and menus

- pages/theme_template/loggedin_homepage.php for logged in homepage
- pages/theme_template/public_homepage.php for public homepage (if no walled garden)
- views/default/page/walled_garden.php for walled garden homepage


