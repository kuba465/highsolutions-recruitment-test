# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|
    config.vm.box = "smoogie/sourcebox"
    config.vm.network "private_network", ip: "192.168.33.30"
    config.vm.hostname = "swapi-people"
    config.vm.synced_folder ".", "/var/www", :mount_options => ["dmode=777", "fmode=777"]
    config.vm.network "forwarded_port", guest: 80, host: 8321
end
