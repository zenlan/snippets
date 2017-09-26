# Installing Vagrant on Windows 10

## Git for Windows

[Download](https://git-scm.com/download/win)

"Use Git from the Windows Command Prompt"
"Checkout as-is, commit Unix-style line endings"


## VirtualBox

[Download both VirtualBox and VirtualBox extensions](https://www.virtualbox.org/wiki/Downloads)

Open VirtualBox, select File -> Preferences -> Extensions, navigate to the 
downloaded extensions file and select.

## Vagrant

[Windows Download](https://www.vagrantup.com/downloads.html)

* Run the Vagrant executable
* [Enable Intel Virtualization Technology](https://www.intel.com/content/www/us/en/support/processors/000005486.html)
* Virtual Box will not work if Hyper-V is enabled, disable/remove it via Windows Features

## Running Vagrant on Windows 10

* Open Git Bash and type "pwd", you should see the current directory, e.g.
```
$ pwd
/c/Users/your_username
```
* Change to another drive/directory, e.g. D:\vagrant
```
$ cd d:\vagrant
$ pwd
/d/vagrant
```
* Create a folder to store a Vagrant box, e.g. Ubuntu, and change to that directory.
```
$ mkdir ubuntu
$ ls
/ubuntu
$ cd ubuntu
$ pwd
/d/vagrant/ubuntu
```

## Creating a Vagrant box from an online VirtualBox image

* Show "init" options
`$ vagrant init --help`
The version parameter is required and references an existing image that will be used to create the box.

[Discover Vagrant Boxes](https://app.vagrantup.com/boxes/search?provider=virtualbox)

* Initialise the Vagrant directory for the Ubuntu Trusty64 image
`$ vagrant init ubuntu/trusty64`
* Show "up" options
`$ vagrant up --help`
* Create the box and run it, VirtualBox should be the default provider
`$ vagrant up`
* The default provider should be VirtualBox, if not then specify it
`$ vagrant up –-provider=virtualbox`
* Show if the box is running
`$ vagrant status`
* Save the box’s current state
`vagrant suspend`
* Shut down the box
`$ vagrant halt`
* Shutdown and delete the box
`vagrant destroy`

## Using and managing a Vagrant box

Do not use the VirtualBox Manager to change box settings or it will be out of sync with Vagrant. 

The box should be listed in the VirtualBox Manager where you can click Show to use the terminal. 

[Default login for a vagrant box is vagrant|vagrant](https://github.com/fideloper/Vaprobash/issues/347)

"Rebooting the VM within Virtualbox gets it "out of sync" with Vagrant."

"Vagrant sets up networking and various other settings which are needed to work 'seemlessly' within Vagrant."

## Creating a Vagrant base box 

Rather than using an online image it is possible, although time-consuming, to create a custom base image
[Creating a Base Box](https://www.vagrantup.com/docs/virtualbox/boxes.html)


## Miscellaneous

[Vagrant Documentation](https://www.vagrantup.com/docs/index.html)

[Scotch Box](https://box.scotch.io/)

[Win10 VBox / Hyper-V / Docker](https://technology.amis.nl/2017/07/17/virtualization-on-windows-10-with-virtual-box-hyper-v-and-docker-containers/)

