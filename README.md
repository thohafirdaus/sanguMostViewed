# Sangu Most Viewed Plugin for OJS 3.4

A generic plugin to display the most viewed articles in the sidebar of OJS 3.4 journals.

## Features

- Displays articles with the highest view counts in the sidebar
- Configurable time period: last 7 days, last 30 days, last 1 year, or all time
- Configurable number of articles to display (3, 5, 10, 15, or 20)
- Supports English and Indonesian languages

## Requirements

- OJS 3.4.x
- Usage statistics data (table `metrics_submission`) must be available

## Installation

1. Copy the `sanguMostViewed` folder to the `plugins/generic/` directory
2. Go to **Settings → Website → Plugins**
3. Find **"Sangu Most Viewed"** under the Generic Plugins category
4. Click **Enable**

## Configuration

1. After enabling the plugin, click the **Settings** button next to the plugin name
2. Select the **Time Period**:
   - Last 7 Days
   - Last 30 Days
   - Last 1 Year
   - All Time *(default)*
3. Select the **Number of Articles** to display (default: 5)
4. Click **Save**

## Displaying in the Sidebar

1. Go to **Settings → Website → Appearance → Sidebar Management**
2. Drag the **"Most Viewed Articles"** block to the sidebar area
3. The block will automatically appear on the journal pages

## File Structure

```
sanguMostViewed/
├── SanguMostViewedPlugin.php          # Main plugin (GenericPlugin)
├── SanguMostViewedBlockPlugin.php     # Sidebar block (BlockPlugin)
├── SanguMostViewedSettingsForm.php    # Settings form
├── version.xml                        # Plugin metadata
├── README.md
├── templates/
│   ├── block.tpl                      # Sidebar template
│   └── settingsForm.tpl              # Settings form template
└── locale/
    ├── en/
    │   └── locale.po                  # English translations
    └── id/
        └── locale.po                  # Indonesian translations
```

## License

Distributed under the GNU GPL v3. For full terms see the file `docs/COPYING`.

