#!/bin/bash
export HOME="/root"
export PATH="/sbin:/bin:/usr/sbin:/usr/bin:/opt/aws/bin"

echo ">>> Supervisor script started..."
#If supervisor is installed
if [ -x /usr/bin/supervisorctl ]; then
    #Stop the queue worker
    echo ">>> Stopping worker"
    supervisorctl stop queue-worker
else
    #Install supervisor
    echo ">>> Installing supervisor"
    pip install supervisor --pre
    mkdir -p /etc/supervisor/conf.d

    cat .ebextensions/supervisord/installer/init.template >> /etc/init.d/supervisord
    chmod +x /etc/init.d/supervisord
    cat .ebextensions/supervisord/installer/sysconfig.template >> /etc/sysconfig/supervisord
    mkdir -p /var/run/supervisord/
    chown webapp: /var/run/supervisord/

    cat .ebextensions/supervisord/installer/config.template >> /etc/supervisord.conf
fi

#Stop supervisor
echo ">>> Stopping supervisor"
service supervisord stop

#Remove current config file
rm -f /etc/supervisor/conf.d/queue-worker.conf

#Set new config file
echo ">>> Setting config"
cat .ebextensions/supervisord/queue-worker.conf >> /etc/supervisor/conf.d/queue-worker.conf

#Start supervisor
echo ">>> Starting supervisor"
service supervisord start
