


## Install Prerequisites:

```
sudo apt install php
sudo apt install composer
sudo apt install nodejs
sudo apt install npm
sudo apt install nginx
```

Please do not include any Chinese characters in the following file paths.

It is recommended to deploy in a testing environment first, and after testing, deploy to the production environment. Pay attention to port conflicts such as 3306 and 80 during deployment.



## Backend
1. Create a new folder, run composer create-project topthink/think=5.0.* tp5 --prefer-dist, and replace the application and public folders from the server-side folder into the newly created folder.
2. Create a new nginx project on the server. Set the document root to the backend path /public, and configure pseudo-static.
3. In the backend path /application/database.php, modify the database username and password.


   ## Frontend 
1. Run npm install to install dependencies for all three frontend projects.
2. Run npm run build to compile the projects for all three frontend projects.
3. Create three new pure static projects in nginx and run the three frontend websites.
