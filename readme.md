Project with Symfony PHP framework (back-end) and Vue.js Javascript framework (front-end). Creating an e-commerce application over time step by step. Using concepts like ORM, routing with annotations, Symfony authentication, Twig template engine, and unit and response testing.

CURRENT FUNCTIONALITY:

Can register, log in and authenticate users, provides access to admin section only for admins. Can add, edit and display products. Can add and remove products from featured products, which are displayed on front page. Has shopping cart functionality.

IF YOU WANT TO TEST THIS:

I unfortunately do not currently have a server I could deploy this on. If you want to, I would recommend installing Symfony, cloning the project and running it on the Symfony development server.

Remember to put put your database credentials etc. to .env.local and .env.test.local.

If you want to run the test suite, run this first to load the fixtures (so the test database has the correct data):

php bin/console doctrine:fixtures:load -e test