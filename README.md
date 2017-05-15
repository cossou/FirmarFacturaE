# Firmar FacturaE 

Sign a FacturaE XML with a certificate (`.p12`).

### How it works

Creates a signed XML `.xsig` file with a correspondent certificate in the same directory as the XML file.

NOTE: The file is created in the same directory of the XML file with the `.xsig` appended to the end of filename.

### Install

Use composer:

```
$ composer require cossou/firmar-factura-e:dev-master
```

### Example

```php
<?php

$firmador = new FirmarFacturaE\Firmador;

try {
    $file = $firmador->firmar('invoice.xml', 'cert.p12', 'password');
} catch (Exception $e) {
    echo $e->getMessage();
}

echo $file; // 'path/to/invoice.xml.xsig' (no content only path)

```

### Requirements

* Java 
* PHP `exec()` function
* PKCS12 certificate and password

### License

MIT