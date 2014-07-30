# Migrations

## Setup

make a file database/local.sqlite

~~~
cd ~/to/the/root/folder/of/this/app
touch database/local.sqlite
~~~~

## Overview

Migrations are easy is some frameworks and this will attempt to bring that ease here as well.

The PhpMig library bring the console migrations back into place.

The root of your application will have several folders and files

Typically you would run

~~~
bin/phpmig init
~~~

To setup folder

~~~
migrations
~~~

And files

~~~
phpmig.php
~~~~

But I included the phpmig to show how to setup Illuminate

Then there are

Folders

~~~
database //to store the local.sqlite file for testing
config //for connecting later on in example queries
~~~

Files

~~~
.env //this is for our db settings as needed more on this later
~~~


## Now that you are setup

~~~
bin/phpmig status
~~~

To see how things are going

~~~
bin/phpmig migrate
~~~

To migrate the 2 demo tables in migrations folder

~~~
bin/phpmig generate OrdersTable
~~~

To make a new table


~~~
bin/phpmig status
~~~

Should show this

~~~
 Status   Migration ID    Migration Name
-----------------------------------------
     up  20140730141914  BooksTable
     up  20140730143621  AuthorsTable
   down  20140730153935  OrdersTable
~~~~

Now we need to edit the new file it made in migrations folder for Orders.

~~~
<?php

use Phpmig\Migration\Migration;

class OrdersTable extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {

    }

    /**
     * Undo the migration
     */
    public function down()
    {

    }
}
~~~

We want to introduce the Illuminate Capsule and schema builder

Lots of good docs here

  * http://laravel.com/docs/schema
  * http://laravel.com/docs/migrations

So for now we are manually writing out / copy paste the syntax so this looks like

~~~
<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Phpmig\Migration\Migration;

class OrdersTable extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        Capsule::schema()->create('orders', function($table)
        {
            $table->increments('id');
            $table->integer('book_id');
            $table->timestamps();
        });
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        Capsule::schema()->drop('orders');
    }
}
~~~

That is it now

~~~
bin/phpmig migrate
~~~

And you are set to go

~~~
bin/phpmig status

 Status   Migration ID    Migration Name
-----------------------------------------
     up  20140730141914  BooksTable
     up  20140730143621  AuthorsTable
     up  20140730153935  OrdersTable
~~~


# Adding Fields

# Seeding the db

# How to now setup your app to query this data