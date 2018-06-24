#!/bin/bash -eu

[ $EUID -eq 0 ] || {
    echo "This script requires root or sudo"
    exit 1
}

#https://lucene.apache.org/solr/guide/6_6/basic-authentication-plugin.html#BasicAuthenticationPlugin-EnableBasicAuthentication

sudo cp security.json /var/solr6/data
sudo chown solr:solr /var/solr6/data/security.json

sudo service solr6 start

curl --user solr:SolrRocks http://localhost:8660/solr/admin/authentication -H 'Content-type:application/json' -d '{"set-user": {"admin":"adminpassword", "guest":"guestpassword}}'
