# Skilltree

A system to visualize learning.

## This project uses

https://github.com/anvaka/panzoom
Modified version of https://github.com/jfmdev/jqSimpleConnect


## Getting started

For the inital setup there are a few steps in cloning this repo

```
git clone https://github.com/jensnti/skilltree.git
cd skilltree
```
setting up the project

installing packages
```
composer install
npm install
```

setting up .env file
```
cp .env.example .env
php artisan key:generate
```
setup a google oauth api project [here](https://console.developers.google.com/)
After creating a project in the developer console, then make a oauth client id
![image of developer console](https://i.imgur.com/mdCegkL.png)
add a authorized redirect, should be ``DOMAIN_NAME/google/callback`` see image above. 
Place Client id, Client secret in the .env file under:
```
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT= # Should match the authorized redirect uri in the developer console
```
After adding database credentials
run ``php artisan migrate``
now all that is left is to compile the frontend
```
npm run dev
```
now for dev purposes run ``php artisan serve`` to launch the server.

## Todo
* Student interface
    * A student that logs in sees dashboard
        * And it's not crap
    * Dashboard shows active skilltrees
* Teacher interface
* Write tests
    * for class invitation, limit account type, validation
    * for administration of tasks
    * for administration of students
* Add some tooltips
    * Overall make UI & UX better
* Activity
    * skilltree activity for teachers
        * x updated, added task etc.
    * skilltree activity for students
        * completed task, added task, did stuff 
* check caching
* Roles - rather than user flag
    * admin
    * teacher
    * student
* Redo classroom implementation
    * load
    * export
    * students

## Finished
* sign in with oAuth
    * a user is a teacher or student
* A user can add, delete manage skilltrees
    * classroom paused
        * Skilltrees can load courses from classroom
        * Classroom can load topics as skills
* A skilltree can have skills
* Skills can be connected
* Skills can have tasks
    * Tasks can be loaded from classroom
    * Tasks can be managed
* Caching Google API requests
* student ui
    * A user can view skilltree and see progress
        * Skills with tasks
        * Tasks completed - First step checkboxes
        * Progress bar on skillcard
* Clean up localstorage
* remove and update students on skilltree
* skilltreeinvite->teacher only. treemodal, update user progresses, reload on student invite, group by skill
