# Dependencies

I suggest installing docker CE and docker-compose.

If you use linux, ensure your user is part of the docker group.
```bash
sudo usermod -aG docker {yourUsername}
```

After that, you would need to logout or restart your computer. This will solve a lot of docker-related permissions issues.


# Getting a working environment going

From a terminal:
```bash
docker-compose up --build
```

If you visit http://localhost in your browser, you should now see the Apigility welcome page. To get the admin UI, you need to enable development mode.
```bash
cp config/development.config.php.dist config/development.config.php
```

As an example, the admin UI says run a command, 'composer development-enable' To translate that to the docker-compose way, that would look like:

```bash
docker-compose exec php composer.phar development-enable
```

## Docker questions:
### What's docker-compose exec versus docker-compose run?

```bash
docker-compose exec {containerName} {command}
```
Exec requires a running container. So you'd first run docker-compose up in one terminal, then run docker-compose exec {containerName}, command

```bash
docker-compose run {containerName} {command}
``` 
Run on the other hand boots up the container and its dependencies then runs the command and finally shuts down the container when the command exits.


### What directory does my command run in?
That depends on the WORKDIR declaration of the Dockerfile. In this app, that's /var/www/html.



## Get the configuration files set for local development
copy the configs/autoload/*.dist to the same spot, minus .dist. The idea here is that the .php files that would be env-specific would be excluded.

Example for one of the files...
```bash
cp configs/autoload/doctrine-orm.global.php.dist configs/autoload/doctrine-orm.global.php
```

**Bonus points:** use dotenv as a project dependency to remove these and just use ENV parameters from a secrets file (see .docker/web/secrets-entrypoint.sh) or ENV parameters injected in via docker-compose or Dockerfile.


Once the web and MySQL instances are running you can then execute commands inside of a container like so:

Install PHP Dependencies from Composer's composer.json and composer.lock file.
```bash
docker-compose exec web php composer.phar install
```

Validate the Doctrine ORM schema matches what's in the database
```bash
docker-compose exec web php vendor/bin/doctrine-module orm:validate-schema
```

Update the local MySQL database schema to match the current entities (no migrations)

```bash
docker-compose exec web php vendor/bin/doctrine-module orm:schema-tool:update --force
```


