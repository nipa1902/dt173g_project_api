# dt173g_project_api
This is the back-end API for the project course in DT173G. 

The link below will take you to the project folder. Each part of the project is hosted seperately and communicates via Fetch API. The project is hosted in three catalogues on my MIUN student website.


## URI

The API has three routers (one per DB table). The following links respond with read all via get request. 

[Courses](http://studenter.miun.se/~nipa1902/writeable/dt173g/projekt/api/courses.php "Courses")
[Jobs](http://studenter.miun.se/~nipa1902/writeable/dt173g/projekt/api/jobs.php "Jobs")
[Websites](http://studenter.miun.se/~nipa1902/writeable/dt173g/projekt/api/websites.php "Websites")

The routes handle full CRUD functionality. The 
[Admin Portal](http://studenter.miun.se/~nipa1902/writeable/dt173g/projekt/admin "Link to admin portal") presents a visual interface to handle CRUD operations using this API.

Routes for CRUD:

* Create (POST) : http://studenter.miun.se/~nipa1902/writeable/dt173g/projekt/api/courses.php
* Read all (GET): http://studenter.miun.se/~nipa1902/writeable/dt173g/projekt/api/courses.php
* Read by ID (GET): http://studenter.miun.se/~nipa1902/writeable/dt173g/projekt/api/courses.php?id=
* Update by ID (PUT): http://studenter.miun.se/~nipa1902/writeable/dt173g/projekt/api/courses.php?id=
* Delete (DELETE): http://studenter.miun.se/~nipa1902/writeable/dt173g/projekt/api/courses.php?id=

Replace "courses.php" with jobs.php / websites.php as needed.

[Project Folder](http://studenter.miun.se/~nipa1902/writeable/dt173g/projekt/ "Link to project folder")