# Compte Rendu - Mini Projet Docker

## Creation du fichier Dockerfile
1. Base Image: Uses the python:3.8-buster image to ensure a consistent Python 3.8 environment on Debian Buster.
```Dockerfile
    FROM python:3.8-buster
```
2. Maintainer Information: Includes metadata (name and email) about the Dockerfile maintainer.
```Dockerfile
    LABEL maintainer="name: your_name, email: your_email@gmail.com"
```
3. Application Script: Copies the `student_age.py` script to the container’s root directory.
```Dockerfile
    COPY student_age.py /
```