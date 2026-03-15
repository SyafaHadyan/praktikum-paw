# Praktikum Pengembangan Aplikasi Web

## Deployment with Docker

- Run the Container ([syafa/praktikum-paw](https://hub.docker.com/r/syafa/praktikum-paw)):

```sh
docker compose up -d
```

> Check logs with `docker logs -f praktikum-paw`

### Manual Build

A Dockerfile is provided in the root directory of this repository

- Build Docker Image

```sh
docker build -t syafa/praktikum-paw:bab3
```
