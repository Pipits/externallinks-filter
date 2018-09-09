# External Links Filter

This is a Perch template filter that allows you to add `target` and `rel` attributes to external links inside `textarea` field types.

## Installation


- Download the latest version of the template filter
- Unzip the download
- Place the `PipitTemplateFilter_externallinks.class.php` file in the folder `perch/addons/templates/filters/`
- Include the class in the file `perch/addons/templates/filters.php`:

```php
include('filters/PipitTemplateFilter_externallinks.class.php');
```

You also need to enable template filters in your config:

```php
define('PERCH_TEMPLATE_FILTERS', true);
```


## Configuration

Specify the site URL in your `config.php`:

```php
define('SITE_URL', 'https://example.com');
```

If the above isn't present, the filter will use the site URL entered in Perch's Settings in the contorl panel.


## Usage

- Specify the filter with `filter="externallinks"`
- To add a `target` to your `<a>` tags, use the `linkstarget` attribute on the `textarea` tag
- To add a `target` to your `<a>` tags, use the `linksrel` attribute on the `textarea` tag

```markup
<perch:content id="desc" type="textarea" filter="externallinks" linkstarget="_blank" linksrel="noopener" markdown>
```