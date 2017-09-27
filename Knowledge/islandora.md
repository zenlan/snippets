# ISLANDORA CLAW

Setting up [Islandora CLAW](https://github.com/Islandora-CLAW) using Vagrant with VirtualBox on Windows 10

See file [\snippets\Knowledge\vagrant.md](vagrant.md) in this repository for a guide to setting up Vagrant on Windows 10 

## Step 1 - Git

Open Git Bash
```
$ cd path\to\vagrant\folders
$ git clone --single-branch https://github.com/Islandora-CLAW/claw_vagrant
```
[Claw Vagrant on Github](https://github.com/Islandora-CLAW/claw_vagrant)

[Windows Troubleshooting](https://github.com/Islandora-CLAW/claw_vagrant#windows-troubleshooting)
```
$ git config --list --global
$ git config --get core.autocrlf
$ git config --set core.autocrlf
```
[Git Configuration on Windows](https://www.onwebsecurity.com/configuration/git-on-windows-location-of-global-configuration-file.html)

## Step 2 - Vagrant

Open path\to\vagrant\folders\claw_vagrant\Vagrantfile and check the port forwarding directives, e.g.
`config.vm.network :forwarded_portt, guest: 8080, host: 8080 # Tomcat`
If any of the host ports are already in use on Windows, e.g. by XAMPP etc., either close them or edit the host value to that of an unused port

If you use a Windows editor to edit and save the file, make sure that you don't change the EOL

Notepad++ has an option to set/convert file EOLs (Edit -> EOL conversion -> UNIX/OSX Format)

In Git Bash
```
$ cd path\to\vagrant\folders\claw_vagrant
$ vagrant up
```
This will take some time as there is a lot to be downloaded and configured 

Make some scones and tea or pop out to the shops

When done, using a Windows browser, navigate to http://localhost:8000 (or whatever port you chose) and login to Drupal

All connection and account details are on the [Github page](https://github.com/Islandora-CLAW/claw_vagrant#connect)
