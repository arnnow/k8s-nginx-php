# Setup a PHP / Nginx / Mysql stack in kubernetes
**For test purposes using minikube**

## Configure PersistentVolume & PersistentVolumeClaim
Set Volume using hostPath.  
You will need to create the directory beforehand in your minikube install
```
{20:48}~/k8s-nginx-php/definitions:master ✗ ➭ minikube ssh
                         _             _
            _         _ ( )           ( )
  ___ ___  (_)  ___  (_)| |/')  _   _ | |_      __
/' _ ` _ `\| |/' _ `\| || , <  ( ) ( )| '_`\  /'__`\
| ( ) ( ) || || ( ) || || |\`\ | (_) || |_) )(  ___/
(_) (_) (_)(_)(_) (_)(_)(_) (_)`\___/'(_,__/'`\____)

$ mkdir /tmp/mysql
$ mkdir /tmp/php
$
```
You can set the PersistentVolume & PersistentVolumeClaim.
```
kubectl apply -f definitions/storages/php_pv_volume.yaml
kubectl apply -f definitions/storages/php_pv_claim.yaml
kubectl apply -f definitions/storages/mysql_pv_volume.yaml
kubectl apply -f definitions/storages/mysql_pv_claim.yaml
```

## Set Secrets
Secret are generated using base64
```
{20:52}~ ➭ echo -n 'thisissecure' | base64
dGhpc2lzc2VjdXJl
```
You can add your base64 encoded secret to the yaml file and apply it
*This is clearly not secure and need a proper secret management tool*
```
kubectl apply -f definitions/secrets/mysql_secret.yaml
```

## Set ConfigMap
```
kubectl apply -f definitions/nginx_configMap.yaml
```

## Set Services
```
kubectl apply -f definitions/nginx_service.yaml
kubectl apply -f definitions/php_service.yaml
kubectl apply -f definitions/mysql_service.yaml
```

## Launch deployment
```
kubectl apply -f definitions/nginx_deployment.yaml
kubectl apply -f definitions/php_deployment.yaml
kubectl apply -f definitions/mysql_deployment.yaml
```
