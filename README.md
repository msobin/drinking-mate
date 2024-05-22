[![Contributors](https://img.shields.io/github/contributors/msobin/drink-mate.svg?style=for-the-badge)](https://github.com/msobin/drink-mate/graphs/contributors)
[![Forks](https://img.shields.io/github/forks/msobin/drink-mate.svg?style=for-the-badge)](https://github.com/msobin/drink-mate/network/members)
[![Stargazers](https://img.shields.io/github/stars/msobin/drink-mate.svg?style=for-the-badge)](https://github.com/msobin/drink-mate/stargazers)
[![Issues](https://img.shields.io/github/issues/msobin/drink-mate.svg?style=for-the-badge)](https://img.shields.io/github/issues/msobin/drink-mate.svg?style=for-the-badge)
[![MIT License](https://img.shields.io/github/license/msobin/drink-mate.svg?style=for-the-badge)]( https://github.com/msobin/drink-mate/blob/master/LICENSE.txt)
[![LinkedIn](https://img.shields.io/badge/linkedin-%230077B5.svg?style=for-the-badge&logo=linkedin&logoColor=white)](https://linkedin.com/in/maximsobin)

<div align="center">
  <a href="https://github.com/msobin/drink-mate">
    <img src="images/logo.png" alt="Logo" width="200">
  </a>
</div>

## About The Project
Your go-to solution for finding the perfect drinking buddy!
Whether you're looking to share a pint with someone new or find a local companion for happy hour, DrinkingMate API has got you covered.
Simply register, mark yourself as ready to clink glasses, and discover like-minded revelers in your area.
No more lonely nights at the bar – with DrinkingMate API, you're just a tap away from turning strangers into friends over a drink (or two).
Cheers to new connections and unforgettable nights!

### Built With
* PHP (Symfony)
* PostgreSQL
* Docker

[//]: # (* [![PHP]&#40;https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white&#41;]&#40;http://php.net/&#41;)
[//]: # (* [![Symfony]&#40;https://img.shields.io/badge/symfony-%23000000.svg?style=for-the-badge&logo=symfony&logoColor=white&#41;]&#40;https://symfony.com/&#41;)
[//]: # (* [![Postgres]&#40;https://img.shields.io/badge/postgres-%23316192.svg?style=for-the-badge&logo=postgresql&logoColor=white&#41;]&#40;https://www.postgresql.org/&#41;)
[//]: # (* [![Docker]&#40;https://img.shields.io/badge/docker-%230db7ed.svg?style=for-the-badge&logo=docker&logoColor=white&#41;]&#40;https://www.docker.com/&#41;)

### Requirements
* [Docker](https://www.docker.com/)
* Docker-compose (comes with Docker)
* [Task](https://taskfile.dev/)

### Installation

Clone the repo
   ```sh
    git clone git@github.com:msobin/drink-mate.git
   ```
Run the following command in project directory to start the project
   ```sh
    task up
   ```
Open your browser and navigate to [http://localhost:80/api/v1/doc](http://localhost:80/api/v1/doc)

*The ports used can be overridden by creating a docker-compose.override.yaml file with the following contents:*
```yaml
version: '3'

services:
  nginx:
    ports: !override
      - "8080:80"

  postgres:
    ports: !override
      - "54321:5432"
```

### Notes

* The project is still in development and some features may not be fully implemented.

### License

[MIT](https://opensource.org/licenses/MIT)
