Uploader
========
_Handle file upload by Symphony 2 framework_

### Instalation
* Use `php composer.phar install` after download to install Symfony 2 framework libraries.
* To use on nginx server add to configuration:
```
client_max_body_size 5M;
location / {
    try_files $uri $uri/ /index.php$is_args$args;
}
```
* Remember to set correct permissions to upload directory

**Max upload file size is 5MB**