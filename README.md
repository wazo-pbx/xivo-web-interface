__Important: Please note this repository is now deprecated in Wazo, we don't support it anymore.__

---------------------------------

Running functional tests
------------------------

You need Xephyr.

    apt-get install xserver-xephyr

You need Geckodriver

    wget https://github.com/mozilla/geckodriver/releases/download/v0.19.1/geckodriver-v0.19.1-linux64.tar.gz
    tar -xvf geckodriver-v0.19.1-linux64.tar.gz
    cp geckodriver /usr/local/bin/geckodriver

1. [XiVO acceptance](https://github.com/wazo-pbx/xivo-acceptance)
2. ```
cd integration_tests
pip install -r test-requirements.txt
make test-setup MANAGE_DB_DIR=/path/to/xivo-manage-db
nosetests suite
```

To change the behaviour of the integration tests, you may configure the
following environment variables:

```
DB_USER (default: asterisk)
DB_PASSWORD (default: proformatique)
DB_HOST (default: localhost)
DB_PORT (default: 15432)
DB_NAME (default: asterisk)
VIRTUAL_DISPLAY (default: 1)
WEBI_URL (default: http://localhost:8080)
CONFD_URL (default: http://localhost:19487)
DOCKER (default: 1) enables the starting/stopping of docker containers for each
    test. May be useful when developing.
```
