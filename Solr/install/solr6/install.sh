#!/bin/bash -eu

[ $EUID -eq 0 ] || {
    echo "This script requires root or sudo"
    exit 1
}

# Solr depends on Java
#apt list --installed | grep ^jre
#apt-get install -y default-jre || sudo yum install -y java-headless

# Look up most recent version at http://archive.apache.org/dist/lucene/solr/
SOLR_VERSION='6.6.0'

wget "http://archive.apache.org/dist/lucene/solr/$SOLR_VERSION/solr-$SOLR_VERSION.tgz"

# Extract just the install script from the bundle
tar xzf "solr-$SOLR_VERSION.tgz" "solr-$SOLR_VERSION/bin/install_solr_service.sh" --strip-components=2

# -d     Directory for live / writable Solr files, such as logs, pid files, and index data; defaults to /var/
# -i     Directory to extract the Solr installation archive; defaults to /opt/
# -p     Port Solr should bind to; default is 8983
# -s     Service name; defaults to solr
# -u     User to own the Solr files and run the Solr process as; defaults to solr
# -n     Do not start Solr service after install, and do not abort on missing Java

./install_solr_service.sh solr-$SOLR_VERSION.tgz -p 8660 -s solr6 -n

rm ./install_solr_service.sh
rm ./solr-$SOLR_VERSION.tgz

echo "NOW SET -Xmx & -Xms IN /etc/default/solr6.in.sh"

echo "open port on ubuntu: 'ufw allow 8660 && ufw status verbose' "

