[![OJS compatibility](https://img.shields.io/badge/ojs-3.5-brightgreen)](https://github.com/pkp/ojs/tree/stable-3_5_0)
[![OMP compatibility](https://img.shields.io/badge/omp-3.5-brightgreen)](https://github.com/pkp/omp/tree/stable-3_5_0)
[![OPS compatibility](https://img.shields.io/badge/ops-3.5-brightgreen)](https://github.com/pkp/ops/tree/stable-3_5_0)
![GitHub release](https://img.shields.io/github/v/release/jonasraoni/googleTagManager?include_prereleases&label=latest%20release&filter=v3*)
![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/jonasraoni/googleTagManager)
![License type](https://img.shields.io/github/license/jonasraoni/googleTagManager)
![Number of downloads](https://img.shields.io/github/downloads/jonasraoni/googleTagManager/total)

# Google Tag Manager Plugin

## About

This plugin allows you to setup the Google Tag Manager.

## Installation

This plugin is compatible with OJS/OMP/OPS 3.5.

1. Download the right package for your application from the releases: https://github.com/jonasraoni/googleTagManager/releases
2. Access Settings > Website > Plugins
3. Click on "Upload A New Plugin" and upload the package

Alternatively, if you want to install from Git, ensure that the plugin branch/version matches your application version.
The destination folder for the plugin should be `plugins/generic/googleTagManager`

Example:

```
cd /path/to/ojs
git clone https://github.com/jonasraoni/googleTagManager.git plugins/generic/googleTagManager
php lib/pkp/tools/installPluginVersion.php plugins/generic/googleTagManager/version.xml
```

## How to use

- Get into the administration interface of a journal
- Access the Settings > Website > Plugins
- Locate the plugin and enable it
- Extend the options of the plugin and open its settings
- Enter your Google Tag Manager ID

## License

This plugin is licensed under the GNU General Public License v3. See the file LICENSE for the complete terms of this license.

## System Requirements

- OJS/OMP/OPS 3.5.0-X.

## Contact/Support

If you have issues, please use the issue tracker (https://github.com/jonasraoni/googleTagManager/issues).
