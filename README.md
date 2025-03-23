# Compte Rendu - Mini Projet Docker

---

## Creation du fichier Dockerfile

1. **Base Image:** _Uses the python:3.8-buster image to ensure a consistent Python 3.8 environment on Debian Buster._

```Dockerfile
    FROM python:3.8-buster
```

2. **Maintainer Information:** _Includes metadata (name and email) about the Dockerfile maintainer._

```Dockerfile
    LABEL maintainer="name: your_name, email: your_email@gmail.com"
```

3. **Application Script:** _Copies the `student_age.py` script to the container’s root directory._

```Dockerfile
    COPY student_age.py /
```

4. **System Dependencies:** _Updates the package list and installs Python development headers along with SASL, LDAP, and SSL libraries which are prerequisites for certain Python packages._

```Dockerfile
    RUN apt update -y && apt install python3-dev libsasl2-dev libldap2-dev libssl-dev -y 
```

5. **Python Dependencies:** _Copies the 'requirements.txt' file into the container. Installs all the Python packages listed in 'requirements.txt' using pip._

```Dockerfile
    COPY requirements.txt /
    RUN pip3 install -r requirements.txt
```

6. **Data Directory and Volume:** _Creates a directory `/data` intended for persistent data storage. Declares `/data` as a volume, allowing the data to survive container re-creation._

```Dockerfile
    RUN mkdir /data
    VOLUME [ "/data" ]
```

7. **Network Configuration:** _Exposes port 5000 to provide access to the running application (likely a web service)._

```Dockerfile
    EXPOSE 5000
```

8. **Startup Command:** _Specifies that the container should run the `student_age.py` script using Python3 as its main process._

```Dockerfile
    CMD [ "python3", "student_age.py" ]
```

📎 **Fichier Dockerfile :** [Dockerfile](./simple_api/Dockerfile)

---

## Test de l'image

1. Build image


```bash
$ docker build -t api:1.0 simple_api/
[+] Building 121.1s (11/11) FINISHED                                                                                                       docker:desktop-linux 
 => [internal] load build definition from Dockerfile                                                                                                       0.0s 
 => => transferring dockerfile: 1.59kB                                                                                                                     0.0s 
 => [internal] load metadata for docker.io/library/python:3.8-buster                                                                                       0.7s 
 => [internal] load .dockerignore                                                                                                                          0.0s 
 => => transferring context: 2B                                                                                                                            0.0s 
 => [internal] load build context                                                                                                                          0.1s 
 => => transferring context: 71B                                                                                                                           0.0s 
 => [1/6] FROM docker.io/library/python:3.8-buster@sha256:04c3f641c2254c229fd2f704c5199ff4bea57d26c1c29008ae3a4afddde98709                                50.9s 
 => => resolve docker.io/library/python:3.8-buster@sha256:04c3f641c2254c229fd2f704c5199ff4bea57d26c1c29008ae3a4afddde98709                                 0.1s 
 => => sha256:819d305a9b2210516eaf5929daf6caa015f1f0ffa8be96252cb05d0f283bfff5 19.29MB / 19.29MB                                                          10.7s 
 => => sha256:0ebfe287e9761b9b7dd1703470ff3473a62fe75238f3de01282165f8725968af 6.15MB / 6.15MB                                                             2.3s 
 => => sha256:a2e1e233599c00054fb839db78b4d42e6f12f36b64280aa62d482a3ad0ad7109 191.88MB / 191.88MB                                                        41.5s 
 => => sha256:b1e7e053c9f6f57c6d95002167a6d57aed6aacf04dd2f8e681cb4f74a7ca4381 51.87MB / 51.87MB                                                          35.5s 
 => => sha256:3b1c264c0ad4598c25048a6dbd3030086cc5c74000e11d04ac27944cb116aabb 17.58MB / 17.58MB                                                           9.8s 
 => => sha256:ac8bb7e1a32398e26c129ce64e2ddc3e7ec6c34d93424b247f16049f5a91cff4 50.45MB / 50.45MB                                                          29.2s 
 => => extracting sha256:ac8bb7e1a32398e26c129ce64e2ddc3e7ec6c34d93424b247f16049f5a91cff4                                                                  2.2s
 => => extracting sha256:3b1c264c0ad4598c25048a6dbd3030086cc5c74000e11d04ac27944cb116aabb                                                                  0.6s
 => => extracting sha256:b1e7e053c9f6f57c6d95002167a6d57aed6aacf04dd2f8e681cb4f74a7ca4381                                                                  2.0s
 => => extracting sha256:a2e1e233599c00054fb839db78b4d42e6f12f36b64280aa62d482a3ad0ad7109                                                                  5.1s
 => => extracting sha256:0ebfe287e9761b9b7dd1703470ff3473a62fe75238f3de01282165f8725968af                                                                  0.2s
 => => extracting sha256:819d305a9b2210516eaf5929daf6caa015f1f0ffa8be96252cb05d0f283bfff5                                                                  0.5s
 => => extracting sha256:a11e135762f00d55e3d68410f1aab593ca9850d9c2ca07f69fb5ac353fc99e0a                                                                  0.0s
 => => sha256:a2e1e233599c00054fb839db78b4d42e6f12f36b64280aa62d482a3ad0ad7109 191.88MB / 191.88MB                                                        41.5s 
 => => sha256:b1e7e053c9f6f57c6d95002167a6d57aed6aacf04dd2f8e681cb4f74a7ca4381 51.87MB / 51.87MB                                                          35.5s 
 => => sha256:3b1c264c0ad4598c25048a6dbd3030086cc5c74000e11d04ac27944cb116aabb 17.58MB / 17.58MB                                                           9.8s 
 => => sha256:ac8bb7e1a32398e26c129ce64e2ddc3e7ec6c34d93424b247f16049f5a91cff4 50.45MB / 50.45MB                                                          29.2s 
 => => extracting sha256:ac8bb7e1a32398e26c129ce64e2ddc3e7ec6c34d93424b247f16049f5a91cff4                                                                  2.2s 
 => => extracting sha256:3b1c264c0ad4598c25048a6dbd3030086cc5c74000e11d04ac27944cb116aabb                                                                  0.6s 
 => => extracting sha256:b1e7e053c9f6f57c6d95002167a6d57aed6aacf04dd2f8e681cb4f74a7ca4381                                                                  2.0s 
 => => extracting sha256:a2e1e233599c00054fb839db78b4d42e6f12f36b64280aa62d482a3ad0ad7109                                                                  5.1s 
 => => extracting sha256:0ebfe287e9761b9b7dd1703470ff3473a62fe75238f3de01282165f8725968af                                                                  0.2s 
 => => extracting sha256:819d305a9b2210516eaf5929daf6caa015f1f0ffa8be96252cb05d0f283bfff5                                                                  0.5s 
 => => extracting sha256:a11e135762f00d55e3d68410f1aab593ca9850d9c2ca07f69fb5ac353fc99e0a                                                                  0.0s 
 => => extracting sha256:a2e1e233599c00054fb839db78b4d42e6f12f36b64280aa62d482a3ad0ad7109                                                                  5.1s 
 => => extracting sha256:0ebfe287e9761b9b7dd1703470ff3473a62fe75238f3de01282165f8725968af                                                                  0.2s 
 => => extracting sha256:819d305a9b2210516eaf5929daf6caa015f1f0ffa8be96252cb05d0f283bfff5                                                                  0.5s 
```
