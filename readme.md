Nette Web Project - Employee app
=================

This is a simple  application using the [Nette](https://nette.org). 
The application is overview the employee database. It allows to create, delete and edit an employee.
The main panel shows a graph of the age of employees. All employee data are save to xml file.

Link to the app:
[https://employee.black-hole.sk/](https://employee.black-hole.sk/)

Installation
------------

Then use command:
    
    cd db_employee
	composer install


If it's necessary install [docker](https://docs.docker.com/engine/install/)

Run project on docker:
    
    docker compose up -d

Open link in browser [http://localhost:8000/](http://localhost:8000/)

Add new attributes
----------------

Follow dir app/Files/employeeStructure.json and add or remove attribute structure:

    'keyOfAttribute'
        'type' - available codes "text,date,option,number"
        'name' - value displayed in app
        'table_view' - attribute displayed in table "boolean"
        'edit_view' - attribute displayed in edit/add view "boolean"
        'required' - is required "boolean"

Example if you want add attribute work position:

    "work_position": {
        "type": "text",
        "name": "Work position",
        "table_view": true,
        "edit_view": true,
        "required": false
    },
