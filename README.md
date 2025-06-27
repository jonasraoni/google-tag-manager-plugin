# Google Tag Manager Plugin

## Installation
This plugin is compatible with OJS/OMP/OPS 3.5.

1. Download the right package for your application from the releases: https://github.com/jonasraoni/google-tag-manager-plugin/releases
2. Access Settings > Website > Plugins
3. Click on "Upload A New Plugin" and upload the package

Alternatively, if you want to install from Git, ensure that the plugin branch/version matches your application version.
The destination folder for the plugin should be `plugins/generic/googleTagManager`

Example:

```
cd /path/to/ojs
git clone https://github.com/jonasraoni/google-tag-manager-plugin.git plugins/generic/googleTagManager
php lib/pkp/tools/installPluginVersion.php plugins/generic/googleTagManager/version.xml
```

## How to use

- Get into the administration interface of a journal
- Access the Settings > Website > Plugins
- Locate the plugin and enable it
- Extend the options of the plugin and open its settings
- Enter your Google Tag Manager ID
