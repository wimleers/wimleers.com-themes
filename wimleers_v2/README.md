# Wimleers V2 Theme

The theme CSS is always generated from one single "Sass":http://sass-lang.com (SCSS syntax) file in the ./css folder: screen.scss. It is important that you never make changes to a *.css file: they will be overwritten whenever a *.scss file is generated.

In order to generate the file you must first "install Sass":http://sass-lang.com/tutorial.html. When installed, fire up your terminal, change your directory to ./css in this theme directory and issue the following command, which will fire up the Ruby Sass compiler:

    scss --watch screen.scss