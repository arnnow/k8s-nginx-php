# Setup a PHP / Nginx 
**For test purposes using [minikube](https://kubernetes.io/docs/setup/learning-environment/minikube/)**

## Configure PersistentVolume & PersistentVolumeClaim
Set Volume using [hostPath](https://kubernetes.io/docs/concepts/storage/volumes/#hostpath).  
You can set the [PersistentVolume](https://kubernetes.io/docs/concepts/storage/persistent-volumes/#persistent-volumes) & [PersistentVolumeClaim](https://kubernetes.io/docs/concepts/storage/persistent-volumes/#persistentvolumeclaims).
```bash
{21:10}~/k8s-nginx-php:master ✗ ➭ kubectl apply -f definitions/storages/php_pv_volume.yaml
persistentvolume/php-pv-volume created
{21:11}~/k8s-nginx-php:master ✗ ➭ kubectl apply -f definitions/storages/php_pv_claim.yaml
persistentvolumeclaim/php-pv-claim created

{21:12}~/k8s-nginx-php:master ✗ ➭ kubectl get pv,pvc -o wide
NAME                               CAPACITY   ACCESS MODES   RECLAIM POLICY   STATUS   CLAIM                    STORAGECLASS   REASON   AGE   VOLUMEMODE
persistentvolume/php-pv-volume     1Gi        RWO            Retain           Bound    default/php-pv-claim     manual                  76s   Filesystem

NAME                                   STATUS   VOLUME            CAPACITY   ACCESS MODES   STORAGECLASS   AGE   VOLUMEMODE
persistentvolumeclaim/php-pv-claim     Bound    php-pv-volume     1Gi        RWO            manual         69s   Filesystem

```

## Set [ConfigMap](https://kubernetes.io/docs/tasks/configure-pod-container/configure-pod-configmap/)
```bash
{21:14}~/k8s-nginx-php:master ✗ ➭ kubectl apply -f definitions/nginx_configMap.yaml
configmap/nginx-config created

{21:14}~/k8s-nginx-php:master ✗ ➭ kubectl get cm -o wide
NAME           DATA   AGE
nginx-config   1      8s

```

## Set [Services](https://kubernetes.io/docs/concepts/services-networking/service/)
```bash
{21:14}~/k8s-nginx-php:master ✗ ➭ kubectl apply -f definitions/nginx_service.yaml
service/nginx created
{21:15}~/k8s-nginx-php:master ✗ ➭ kubectl apply -f definitions/php_service.yaml
service/php created

{21:15}~/k8s-nginx-php:master ✗ ➭ kubectl get svc -o wide
NAME         TYPE           CLUSTER-IP      EXTERNAL-IP   PORT(S)        AGE     SELECTOR
kubernetes   ClusterIP      10.96.0.1       <none>        443/TCP        6m57s   <none>
nginx        LoadBalancer   10.106.80.230   <pending>     80:30362/TCP   48s     app=nginx,tier=backend
php          ClusterIP      10.99.7.132     <none>        9000/TCP       40s     app=php,tier=backend

```

## Launch [Deployment](https://kubernetes.io/docs/concepts/workloads/controllers/deployment/)
```bash
{21:16}~/k8s-nginx-php:master ✗ ➭ kubectl apply -f definitions/nginx_deployment.yaml
deployment.apps/nginx created
{21:16}~/k8s-nginx-php:master ✗ ➭ kubectl apply -f definitions/php_deployment.yaml
deployment.apps/php created

{21:16}~/k8s-nginx-php:master ✗ ➭ kubectl get deployments -o wide
NAME    READY   UP-TO-DATE   AVAILABLE   AGE   CONTAINERS   IMAGES        SELECTOR
nginx   0/1     1            0           40s   nginx        nginx:1.9.1   app=nginx,tier=backend
php     0/1     1            0           35s   php          php:7-fpm     app=php,tier=backend
```

# Checking your deployments
## Checking on your pods
```
{21:18}~/k8s-nginx-php:master ✗ ➭ kubectl get pods
NAME                     READY   STATUS              RESTARTS   AGE
nginx-6b4755dc5b-ckgv6   1/1     Running             0          2m45s
php-86d7b79898-blqt6     0/1     PodInitializing     0          2m40s
```

# Visiting the site
```bash
{21:36}~/k8s-nginx-php:master ✗ ➭ minikube service nginx
|-----------|-------|-------------|-----------------------------|
| NAMESPACE | NAME  | TARGET PORT |             URL             |
|-----------|-------|-------------|-----------------------------|
| default   | nginx |             | http://192.168.99.107:30362 |
|-----------|-------|-------------|-----------------------------|
* Opening service default/nginx in default browser...
```
