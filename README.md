<h1 align="center"><a href="http://www.essedi.es"><img src="http://www.essedi.es/wp-content/uploads/2017/12/cropped-newsletter-logo-essedi.png" alt="Essedi"></a></h1>

# Symfony Base Proyect
***
This proyect is current in development and adding news features.

Installation
============

### Step 1: Download the Repo
Go to your new Proyect folder
```console
  git clone git@github.com:essedi/Symfony-base_proyect.git base
```
### Step 2: 
Now use the bash to run installation
The bash require a Proyect alias and repository as arguments
During installation, the bash ask for apply recipes, use "a" option
Next requiere a valid user and password for your local database 
And ask for a optional enviorments values
```console
  cd base
  bash ./init.php {proyect alias} {github link}
```

Know Issues
============
Eventualy api platform or easyadmin cant loads styles and some assets correctly
Try to reinstall assets
```console
php bin/console assets:install --symlink
´´´
If this doesn't works check public folder permissions and the base url is the real url of your virtualhost

