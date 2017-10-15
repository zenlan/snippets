#!/bin/bash -eu

sudo service solr6 stop
sudo rm /etc/default/solr6.in.sh
sudo rm -R /etc/init.d/solr6
sudo rm -R /opt/solr6
sudo rm -R /opt/solr-6.6.0
sudo rm -R /var/solr6
