# rasptell
Project for KTH course II1302 Projects and Project Methods

## Github workflow

### Getting started

Clone the repository using an HTTPS or SSH URL obtained from the green button on the main page of the repo.

`git clone <URL>`

You will probably only need to do this step once.

### Creating a branch

When you have decided what to start working on, it is time to make a new branch for your work. First, make sure you are on the master branch.

`git chechout master`

Second, fetch any remote changes that might have occurred since last time you fetched.

`git fetch`

`git status`

If it turns out that your local master is behind the remote master, you should update your local master with the pull command.

`git pull`

Third, create a new branch with a descriptive name and check it out. This can be done with a single command.

`git checkout -b <new branch name>`

As usual, you can use `git status` to make sure that everything worked correctly.

### Working on a branch

We have only one guideline so far for commits in this repo:

- Commit messages must be in english, present tense, and they should be short and descriptive.

Here is some general advice:

- Fetch often! Fetching is safe and does not change your branch, it just checks if changes have been made to the remote. Then you can decide if you want to merge/pull those changes into your branch (you generally want to).
- Commit often! Commit messages are great for self documentation.
- Avoid commiting irrelevant changes! I.e. try to only commit the files that you actually worked on. Use `git status` and follow the instructions to select which files to include in a commit.

### Pushing your branch

At the end of the workday it is a good idea to push your branch to the remote repo, so that everything is safely backed up.

`git push`

The first time you do this on a new branch, git might ask you to set what upstream (remote) branch to push to. Just follow the instructions in git and a remote branch corresponding to your local one will be created and used.

### Making a pull request

When you feel that you are finished with whatever you are working on, you will want to merge it into the master branch. In this repository we do that by creating a pull request.

- Go to your branch page on GitHub.
- Click the **New pull request** button.
- Configure the details.

There are tons of fancy features for pull request, but just a short description should be enough for us. You can read more [here](https://help.github.com/articles/about-pull-requests/) and [here](https://help.github.com/articles/creating-a-pull-request/) if you are interested.

### Further reading

- Good and entertaining reading to better understand git: [The Git Parable](http://tom.preston-werner.com/2009/05/19/the-git-parable.html)
- The difference between fetch and pull: [Fetch vs Pull](https://www.git-tower.com/learn/git/faq/difference-between-git-fetch-git-pull)
