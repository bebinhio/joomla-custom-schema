# Custom Schema for Articles & Menus - Joomla 4

Lightweight, high-performance Joomla 4 System Plugin that adds a dedicated textarea to articles and menu items for inserting structured data (JSON-LD / Schema.org).

## 🚀 Features

- **Native Integration**: Seamlessly adds a "Custom Schema" tab into the Joomla 4 Article and Menu Item forms.
- **High Performance**: Reads schema data directly from native parameters (`attribs` / `params`) without any extra database queries or heavy extensions.
- **Positioning**: Choose in the plugin settings whether you want the `<script type="application/ld+json">` tag outputted in the `<head>` or just before the closing `</body>` tag (footer).
- **Supports Multiple Contexts**: Works for both single Articles and any Menu Items (e.g. Category Blogs, Contact Pages).

## 📥 Installation

1. Zip the `plg_system_customschema` folder into `plg_system_customschema.zip`.
2. Log into your Joomla 4 Administrator Panel.
3. Go to **System > Install > Extensions**.
4. Upload the zip file.
5. Go to **System > Manage > Plugins**, search for `System - Customschema` and enable it.

## 🛠️ Usage

1. Open any **Article** or **Menu Item**.
2. Navigate to the new **Custom Schema** tab.
3. Paste your raw JSON-LD markup. *(Do not include the `<script>` tags, the plugin adds them automatically)*.
4. Save the item. 

## ⚙️ Configuration

In the Plugin settings (**System > Manage > Plugins > System - Customschema**), you can configure:
- **Schema Position**: Choose whether to output the schema in the `head` tag or `footer`.

## 👨‍💻 Development & Author

Created by: BSIDEWORK - BB
License: GNU General Public License version 2 or later.
