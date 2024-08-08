# open-bike
An open source project to support bike coops - organizations that repair bicycles to give to clients

# Status
Initial development

Defining bikes, establishing application architecture

# Installation/Development
1. [Prepare the server for Symfony](https://symfony.com/doc/current/setup.html)
1. Download/clone or fork the repo
1. [Setup a database](https://symfony.com/doc/current/the-fast-track/en/7-database.html)
1. Run `composer install`
1. Setup `.env.local` - specifically the database connection and the organization text - override the text from `.env`
1. For development, you may use `symfony server:start` and navigate to `http://127.0.0.1:8000`
1. For deployment, [configure the web server](https://symfony.com/doc/current/setup/web_server_configuration.html)

# Access Control
To create an admin user use `bin/console app:add-admin email@example.com password`