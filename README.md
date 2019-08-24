# Skilltree
Stuff

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