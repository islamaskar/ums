# UMS
Simple User Managment System built using Symfony 4.3 and MySQL DBMS 5.7 with these features.

* As an admin I can add users — a user has a name.
* As an admin I can delete users.
* As an admin I can assign users to a group they aren’t already part of.
* As an admin I can remove users from a group.
* As an admin I can create groups.
* As an admin I can delete groups when they no longer have members.

## App launching
After cloning the repository, You can run the application either by `docker-compose` or the normal way by installing the dependencies, loading the databse and running the local server.

Firstly, clone the repository: 

`https://github.com/islamaskar/ums.git`

### Using `docker-compose` 
Please make sure that docker is installed and the daemon is running, consult [Docker docs](https://docs.docker.com/install/) if needed. Make sure also that **docker compose** is installed.

then run:

`docker-compose up` 

It will take some time to build.

After running the containers, you can access the app by opening this URL: http//:localhost:8080

To run any command inside the container, use 

`docker-compose run app bin/console debug:router`, replace the part after `app` with your command.

### Normal way
* Install PHP dependancies using Composer `composer install`
* Install JS dependancies using yarn `yarn install` ~ please make sure that **NodeJS** (~>8.0) is installed
* Fix the database configuration in the `.env` or create your local `.env.local` 
* Create the database `bin/console doctrine:database:create`
* Run the migrations `bin/console doctrine:migrations:migrate`
* Bundle web assests `bin/console assets:install`
* You can load the fixtures to fill the database `bin/console doctrine:fixtures:load`
* Run the local development server, then navigate to http//:localhost:8000

#### Screenshots
![Users](https://imgur.com/CrPhnop.png)
![Groups](https://i.imgur.com/qdyj6JR.png)


## Testing
There is one functional test for the Group controller with **7 test cases** to test the CRUD functionality, you can run it using

`php bin/phpunit` or
`docker-compose run app php bin/phpunit`

## API endpoints
You can see the api documentation for the proposed endpoints by opening one of these URLs (depending on the launching method):  http//:localhost:8080/docs or http//:localhost:8000/docs

![API](https://i.imgur.com/t8cpKN6.png)

## Database Model (ERD)
![ERD](https://i.imgur.com/kAKHdA2.png)

## Domain Model
![DM](https://i.imgur.com/Lei4100.png)





