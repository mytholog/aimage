aimage
======

Working on images asynchronously


#### How to use

Let’s create our test image first:

``` sh
$ convert magick:rose test.jpg
```

From the command-line run the thumbnail script:
``` sh
$ convert magick:rose test.jpg
```

In a separate terminal window run the event collector:
``` sh
$ php collector.php 
```

And finally run the client to send the thumbnail request:
``` sh
$ php client.php 
```
