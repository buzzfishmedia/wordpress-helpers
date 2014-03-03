wordpress-helpers
=================

Collection of classes to ease development with WordPress


This folder(`wordpress-helpers`) belongs in the `wp-content/mu-plugins` equivalent folder.

Inside the directory is `loader.php` which needs to be moved into the root of `mu-plugins`. You should probably rename it to something less generic. I add
```
...

"scripts": {
  "pre-autoload-dump": [
    "cp content/mu-plugins/wordpress-helpers/loader.php content/mu-plugins/loader-wordpress-helpers.php"
  ]
}

...

```

to the root `composer.json`.
