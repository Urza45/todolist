# TO DO LIST

Improve an existing application of ToDo & Co - Project P8 Openclassrooms

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/07af0d2a3f37423fb0e55d29b0afb30d)](https://www.codacy.com/gh/Urza45/todolist/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Urza45/todolist&amp;utm_campaign=Badge_Grade)

## Context

ToDo & Co is a startup whose core business is an application to manage daily tasks.
The application had to be developed at full speed to show potential investors that the concept is viable (we are talking about Minimum Viable Product MVP).
The choice of the previous developer was to use the Symfony PHP framework.
The company ToDo & Co having succeeded in raising funds to allow the development of the company and especially of the application, you are hired as an experienced developer in charge of the following tasks:
    - Implementation of new features.
    - The correction of some anomalies.
    - Implementation of automated tests.

## Description of need

### Bug fixes

    - A task must be attached to a user:
        o When saving the task, the authenticated user is attached to the newly created task
        o When editing the task, the author cannot be changed.
        o For tasks already created, they must be attached to an “anonymous” user.
    - Choose a role for a user: When creating a user, it must be possible to choose a role for it. The roles listed are:
        o User role (ROLE_USER);
        o Administrator role (ROLE_ADMIN).

### Implementation of new features

    - Permission
        o Only users with the administrator role (ROLE_ADMIN) should be able to access the user management pages.
        o Tasks can only be deleted by users who created the task in question.
        o Tasks attached to the “anonymous” user can only be deleted by users with the administrator role (ROLE_ADMIN).
    - Implementation of automated tests: 
        You are asked to implement the automated tests (unit and functional tests) necessary to ensure that the operation of the application is in line with the requests.

### Technical documentation

You are asked to produce documentation explaining how the authentication implementation was done. This documentation is intended for the next junior developers who will join the team in a few weeks. In this documentation, it should be possible for a beginner with the Symfony framework to:

    - Understand which file(s) need to be modified and why;
    - How authentication works;
    - Where are users stored.

In addition, you lead the way in terms of collaboration with several people on this project. You are also asked to produce a document explaining how all developers wishing to make changes to the project should proceed.
This document should also detail the quality process to be used as well as the rules to be respected.

### Code quality audit & application performance

The founders wish to perpetuate the development of the application. That said, they first want to make an inventory of the technical debt of the application.
At the end of your work on the application, you are asked to produce a code audit on the following two axes: code quality and performance.

## Pre-requisites

The present project was developed with:

    - PHP 7.4.30 (cli) (built: Aug  4 2020 11:52:41)
    - MySQL  5.7.31 Community Server (GPL)

## Installation

1.Clone Repository on your web server :

    ```text
    git clone git@github.com:Urza45/todolist.git
    ```

2.Install dependencies, in a command prompt:

    ```text
    composer install
    ```

3.Configure BDD connect on `.env` file

4.Create database, migrations and fixtures, in a command prompt:

    composer prepare

7.Account fixtures:

    - Login  : admin
    - Pass   : admin

    - Login  : user1
    - Pass   : admin
