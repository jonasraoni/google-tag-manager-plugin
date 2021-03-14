# Google Tag Manager Plugin

## Installation
This plugin is compatible with OJS/OMP/OPS 3.2.1 or newer.

Ensure that the plugin branch/version matches your version.
The destination folder for the plugin should be `plugins/generic/googleTagManager`

For example, to install this plugin via git:

```
cd /path/to/ojs
git clone https://github.com/jonasraoni/google-tag-manager-plugin.git plugins/generic/googleTagManager
php lib/pkp/tools/installPluginVersion.php plugins/generic/googleTagManager/version.xml
```

## How to use

- Get into the administration interface of a journal
- Access the Website > Plugins
- Locate the plugin and enable it
- Extend the options of the plugin and open its settings
- Enter your Google Tag Manager ID and then everything should be working.
