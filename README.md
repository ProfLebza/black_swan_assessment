# Black Swan Assessment

## Installation
Please note that I am using yarn for my front-end packages.

Once you have run composer install, don't forget to run:

    * composer dump-env dev/prod (Update your .env.local.php file with your envrinment's details)
    * yarn run dev/prod
    * doctrine:migrations:migrate
    * doctrine:fixtures:load

Data fixtures will setup a user along with a token that can be used to access the API

I built something simple and quick so that I can have this assignment sent to you without delay

Please also note that I am using 2 authenticators

### Url rewrite documents:

Please create the below files in the public folder of the project, to point the requests to index.php file

    * Windows Server: web.config
    * Linux Server: .htaccess

### API Requests

To make an API request, make sure your headers include "X-AUTH-TOKEN" as a key, and your user API Token field as a value.
To post a contact to the API, you would use the url */api/create-contact*, then add the following parameters (Send via POST method):

    * [name: '', email: '', message:'']