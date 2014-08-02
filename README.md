ZnerG
=====

A Mobile sales tracking system with workflow functionality using Laravel.

Although the current version is fully functional, this is still pretty much a work in progress.
I will be adding more comments and documentation that explains each part of the application.
The main goal was to create the DB with all the structure needed to support the workflow functionality. 
Some data needs to be provided directly to the database.

Description:
This application keeps track of your sales representatives activities in the field. It gives them the tools to collect data from customers for follow ups.
The Management will be able to design one or many processes for different customers or campaigns. 
Each process can be defined with specific activities to be executed by specific users or positions in the organization.
The manager can also define the data/fields that he wants the process to work with. Rules, conditions and validations are used to transition from one activity to the other.
Sales representatives find their ToDo activities in an easy to use way so they can be more productive in the field.

Main features:
- Responsive design
- MultiLanguage
- Multi Level parameter configuration (Global, by Organization, by User)
- Menu option 100% configurable
- Control access to menu options by user, role, group (Read, Update, Insert, Delete, Execute)
- Virtual databases for each customers'data
- Use of Google Places & Google Maps APIs & HTML5 Geolocation
- Use of AJAX & Fulltext Search 
- Audit and Log funcionality

The functionality that is currently working is:
1. Login/Logout
2. Register & Forgot your password
3. 




Known issues:
1. There is a tweak that needs to be done to make the application work in desktop and tablet presentation. The focus was to make it functional for mobile devices.
2. The back button inside the Task Creation/Editing, doesn't work in specific scenarios (when the user click refresh) 
3. There are a few sections where exist hard coding. That was done on purpose due to limited resources. I will be upgrading that.

Future work:
1. Fix current issues.
2. Complete the UI for rules definition.
3. Allow the user to update a metaData structure after the process has been initialized.
4. Create the Application functionality to provide the user with the tools to define the look and feel of each activity's UI.
5. Create functionality to allow the user to create their own reports and graphs. Evaluate third party components.
6. Improve maps functionality to show different icons according to the status of each task
7. Add history of executed task.
8. Manage changes in a process in execution to transfer instances from activities no longer available or conditions out of reach
3. Create the functionality 
2. Incorporate Sass & Compass to the project
3. Use of AngularJs for UI with intensive interaction (Tasks execution).
4. Create the UI to define the processes for the workflow
5. 







If you want to test the app, please contact me to give you access and further instructions.
