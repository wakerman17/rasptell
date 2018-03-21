# rasptell
Project for KTH course II1302 Projects and Project Methods

Good and entertaining reading to better understand git: [The Git Parable](http://tom.preston-werner.com/2009/05/19/the-git-parable.html)

## Github workflow

### Getting started

Clone the repository using an HTTPS or SSH URL obtained from the green button on the main page of the repo.

`git clone <URL>`

You will probably only need to do this step once.

### Create branch

When you have decided what to start working on, it is time to make a new branch for your work.

First, make sure that you are currently on the master branch, and that your local repo is up-to-date with the remote repo:

`git status`

`git fetch`

Second, create a new branch with a descriptive name and check it out. This can be done with a single command:

`git checkout -b <new branch name>`

As usual, use `git status` to make sure that everything worked correctly.

