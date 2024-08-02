# ITMTWeb
Versión web del ITMT

# 1. Descargar software:

Es necesario clonar el repositorio y, además, cargar el submódulo de "app/topicmodeler/"

```bash
git clone git@github.com:beauseant/ITMTWeb.git
git submodule init
git submodule update --recursive --remote
```

# 2. Preparar el entorno:

## Crear usuarios:

Editar el fichero auth/logins.txt y añadir un usuario con su contraseña por cada línea:

| login | password  ̣|
| ----- | :--------:|
| itmt  |   itmt    |

Poblar la base de datos auth.db con esos usuarios:

 ```bash
cd auth
python createuser.py
 ```

## Configurar las rutas del sistema:

Editar el fichero app/config.php y definir las rutas donde se salvan los ficheros de corpus, wordlists... Se trata de las rutas internas dentro del contenedor, por lo que en principio no deberían tocarse:

 ```php
   $path_downloaded = '/data/topicmodeler/fromHDFS'; 
   $path_datasets   = '/data/topicmodeler/scalability/datasets';
   $path_TMmodels   = '/data/topicmodeler/scalability/TMmodels';
   $path_wordlists  = '/data/topicmodeler/wordlists';
   $mallet_path	    = '/export/usuarios_ml4ds/lbartolome/mallet-2.0.8/bin/mallet';
   $temporaltrainfile = '/data/topicmodeler/prueba/TMmodels/prueba_saul/train.json';

 ```

## Modificar la ruta en el docker-compose:

En el docker-compose se define el repositorio con los datos del topicmodeler que es montado en el directorio /data del contenedor:

```bash
/export/usuarios_ml4ds/lbartolome/:/data/
```
En el ejemplo anterior, dentro de /export/usuarios_ml4ds/lbartolome/ debemos tener toda la estructura de directorios, fromHDFS, scalability, wordlists....


## Definir las variables de entorno:

Es necesario definir el id del usuario y el grupo (para montar en el contenedor con permisos de lectura y escritura) y la clave de OPENAI que se le pasará a los scripts:
 
 ```bash
 export MYUID=$(id -u)
 export GID=$(id -g)
 export OPENAI_API_KEY=sk-XXXXXX

 ```

 En el caso de que el dueño del repositorio con los modelos no sea el usuario actual, debe ponerse el id que le corresponda. Por ejemplo:

  ```bash
  id fulanito
  uid=2881(fulanito) gid=100(users) groups=100(users),27(sudo),121(docker),10555(intelcomp),10553(ml4ds),2622(cluster)
 export MYUID=2881
 export GID=100
 export OPENAI_API_KEY=sk-XXXXXX

 ```

 ## Crear y ejecutar el docker:

 ```bash
docker-compose build
docker-compose up -d

 ```

 # 3. Comandos útiles:

Para ejecturar un bash con dentro del contenedor:

```bash
docker exec  -it ITMTWeb  bash
#O, si se quiere entrar como root
docker exec  -u root -it ITMTWeb  bash
```

Si al arrancar el docker-compose da un eror del tipo: docker.errors.DockerException: Error while fetching server API version: Not supported URL scheme http+docker

```bash
 pip3 install requests==2.31.0
pip install 'urllib3<2'
```




