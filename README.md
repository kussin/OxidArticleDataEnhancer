# Kussin | Article Data Enhancer for OXID eShop

The "Kussin | Article Data Enhancer for OXID eShop" is an essential module designed to extend the functionalities of the OXID eShop platform. This module works in conjunction with the "Kussin | ChatGPT Content Creator for OXID eShop" and the "Kussin | OXID 6 FACT Finder Export Queue" to enhance your e-commerce solutions.

## Features

- **Data Conversion:** Convert CSV data into JSON format, making it easier to manage and integrate within various systems.
- **REST API Integration:** Provides a RESTful API to allow easy access and manipulation of the stored data.
- **Metadata Provision:** Specifically designed to furnish metadata for AI content generation or search result optimization, improving the relevance and accuracy of your content and search features.

## Related Modules

- [Kussin | ChatGPT Content Creator for OXID eShop](https://github.com/kussin/OxidChatGptContentCreator): Seamlessly generates content using AI, enhancing user engagement and content relevance.
- [Kussin | OXID 6 FACT Finder Export Queue](https://github.com/kussin/OxidFactFinderExportQueue): Improves the management and synchronization of product data with FACT Finder, optimizing search and recommendation capabilities.

## Third-Party Data Integration

Leverage third-party data such as from [nmedia.hub](https://hub.nmedia.solutions/) to enrich product information, thereby enhancing the shopping experience and optimizing search results.

This module is an excellent choice for OXID eShop users looking to enhance their e-commerce capabilities through advanced data management and integration. Explore the possibilities with "Kussin | Article Data Enhancer for OXID eShop" and take your e-commerce platform to the next level.

## Requirement

1. OXID eSales CE/PE/EE v6.4 or newer
2. PHP 7.4 or newer

## Installation Guide

### Initial Installation

To install the module, please execute the following commands in OXID eShop root directory:

   ```bash
   composer config repositories.kussin_chatgpt vcs https://github.com/kussin/OxidArticleDataEnhancer.git
   composer require "kussin/article-data-enhancer":"dev-dev" --no-update
   composer clearcache
   composer update --no-interaction
   vendor/bin/oe-console oe:module:install-configuration source/modules/kussin/article-data-enhancer/
   vendor/bin/oe-console oe:module:apply-configuration
   ```

**NOTE:** If you are using VCS like GIT for your project, you should add the following path to your `.gitignore` file:
`/source/modules/kussin/`

## User Guide

[User Guide](USER_GUIDE.md)

## Bugtracker and Feature Requests

Please use the [Github Issues](https://github.com/kussin/OxidArticleDataEnhancer/issues) for bug reports and feature requests.

## Support

Kussin | eCommerce und Online-Marketing GmbH<br>
Fahltskamp 3<br>
25421 Pinneberg<br>
Germany

Fon: +49 (4101) 85868 - 0<br>
Email: info@kussin.de

## Licence

[End-User Software License Agreement](LICENSE.md)

## Credits

* [Radu Lepadatu](https://github.com/Radulepy) for creating [`Radulepy/PHP-ChatGPT`](hhttps://github.com/Radulepy/PHP-ChatGPT/)

## Copyright

&copy; 2006-2024 Kussin | eCommerce und Online-Marketing GmbH