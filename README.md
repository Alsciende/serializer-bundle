# serializer-bundle [![Build Status](https://travis-ci.org/Alsciende/serializer-bundle.svg?branch=master)](https://travis-ci.org/Alsciende/serializer-bundle)

This Symfony bundle uses the Doctrine metadata and a few annotations of his own to import data from JSON files to the database.

## Overview

### Source Discovery

`ScanningService` uses the Doctrine ClassMetadataFactory to find all entity classes, then filters the ones that use the `@Skizzle` annotation.

### File Reader

For each source discovered, `StoringService` reads the file(s) associated.

### Decoder

For each file read, `EncodingService` decodes the file as an array of JSON objects (ie associative arrays).

### Fields Normalization

For each data array (json object) decoded, `NormalizerManager` uses the `@Skizzle\Field` annotations to transform the serialized value of each key/value pair as a value of the expected type.

### Hydratation

Each data array is then hydrated into a PHP object of the correct class by `MetadataService`.

At that point, all the JSON data is transformed in PHP objects that can be validated, serialized, etc.

### Merging

Each object is merged with the database by `MergingService`. The result is a managed entity whose properties have been updated if they were present in the JSON data. 

### Importer

The `ImporterService` service takes a Source and returns an array of php objects. It bundles the calls to `StoringService`, `EncodingService`, `NormalizerManager` and `MetadataService`. 

## Example

```php
$sources = $scanning->findSources();

foreach ($sources as $source) {
    $fragments = $importer->importSource($source, $this->jsonDataPath);
      
    foreach ($fragments as $fragment) {
        $validator->validate($fragment->getEntity());
        $merging->merge($fragment);
    }
    
    $entityManager->flush();
}
```