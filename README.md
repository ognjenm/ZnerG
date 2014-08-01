ZnerG
=====

A Mobile sales tracking system with workflow functionality using Laravel.

Although the current version is fully functional, this is still pretty much a work in progress application.
I will be adding more comments and documentation that explains each part of the code.
The focus has been to create the DB with al the structure needed to support workflow functionality. 
Some data needs to be provided directly to the database.

Description:
This applications keeps track of your sales representatives activities in the field. It gives them the tools to collect data from customers for follow ups.
The Management will be able to design one or many processes for different customers or campaigns. 
Each process can be defined with specific activities to perform by specific users or positions in the organization
The manager can also define the data/fields that he wants the process to work with. Rules, condition, validations are used to transition from one activity to the other.
Sales representatives find their ToDo activities in an easy to use way so they can be more productive in the field

Main features:
- Responsive design
- MultiLanguage
- Multi Level parameter configuration (Global, by Organization, by User)
- Menu option 100% configurable
- Control access to menu options by user, role, group (Read, Update, Insert, Delete, Execute)
- Virtual databases for each customers'data
- Use of Google Places & Google Maps APIs & HTML5 Geolocation
- Use of AJAX & Fulltext Search 
- Audit/Log funcionality
- 

The functionality that is currently working is:
1. Login/Logout
2. Register & Forgot your password
3. 




Known issues:
1. There is a tweak that needs to be done to make the application work in desktop and tablet presentation. The focus was to make it functional for mobile devices.
2. The back button inside the Task Creation/Editing, doesn't work in specific scenarios (when the user click refresh) 
3. There are a few sections where exist hard coding. That was done on purpose due to limited resources. I will be upgrading that.

Future work:
1. Fix current issues
3.
2. Incorporate Sass & Compass to the project
3. Use of AngularJs for UI with intensive interaction (Tasks execution).
4. 







If you want to test the app, please contact me to give you access and further instructions.
