# wrun

```
Alias /__run /var/www/vhosts/runner
<Directory /var/www/vhosts/runner>
    Require all granted
    FallbackResource ./runner.php
</Directory>
```
