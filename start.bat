rem   comments should begin with rem
rem   note: this file launches all of my favorite apps!
rem   note: replace the names below with your own..

@echo off
   cd api
   start php spark serve
   cd ..
   cd public
   start npm run serve
   cd ..

@echo on