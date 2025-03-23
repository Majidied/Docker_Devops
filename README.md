# Compte Rendu - Mini Projet Docker

## Creation du fichier Dockerfile
1. Base Image: _Uses the python:3.8-buster image to ensure a consistent Python 3.8 environment on Debian Buster._
```Dockerfile
    FROM python:3.8-buster
```
2. Maintainer Information: _Includes metadata (name and email) about the Dockerfile maintainer._
```Dockerfile
    LABEL maintainer="name: your_name, email: your_email@gmail.com"
```
3. Application Script: _Copies the `student_age.py` script to the container’s root directory._
```Dockerfile
    COPY student_age.py /
```
4. System Dependencies: _Updates the package list and installs Python development headers along with SASL, LDAP, and SSL libraries which are prerequisites for certain Python packages._
```Dockerfile
    RUN apt update -y && apt install python3-dev libsasl2-dev libldap2-dev libssl-dev -y 
```

5. Python Dependencies: _Copies the 'requirements.txt' file into the container. Installs all the Python packages listed in 'requirements.txt' using pip._
```Dockerfile
    COPY requirements.txt /
    RUN pip3 install -r requirements.txt
```

6. Data Directory and Volume: _Creates a directory `/data` intended for persistent data storage. Declares `/data` as a volume, allowing the data to survive container re-creation._
```Dockerfile
    RUN mkdir /data
    VOLUME [ "/data" ]
```
7. Network Configuration: _Exposes port 5000 to provide access to the running application (likely a web service)._
```Dockerfile
    EXPOSE 5000
```
8. Startup Command: _Specifies that the container should run the `student_age.py` script using Python3 as its main process._
```Dockerfile
    CMD [ "python3", "student_age.py" ]
```

[./simple_api/Dockerfile]{Dockerfile}