#!/bin/bash
set -e

( cd /etc && chmod 644 resolv.conf /etc/hosts* /etc/localtime ) || true
( cd /dev && chmod 666 full null random tty urandom zero      ) || true
chmod 711 / /etc/ /var/log/;
addgroup --gid 600 aibolit;
adduser --quiet --system --disabled-login --no-create-home --uid $USER_UID --gid 600 aibolit;
mkdir -p $CHECK_DIR;

echo "#!/bin/bash" > /home/beget/aibolit/run.sh
echo "cd /home/beget/aibolit/src;" >> /home/beget/aibolit/run.sh
echo "/usr/bin/php -d short_open_tag=1 ai-bolit.php --skip-cache --addprefix=$CHECK_DIR_ALL --noprefix=/home/beget/site -p /home/beget/site -m 3096M --mode=$MODE --report=/home/report/$REPORT" >> /home/beget/aibolit/run.sh
echo "echo \$? > /home/report/$REPORT.status" >> /home/beget/aibolit/run.sh

chmod 755 /home/beget/aibolit/run.sh;
sudo -u aibolit /bin/bash /home/beget/aibolit/run.sh;
# EOF