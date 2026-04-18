# Robots.txt Editor

Manage your site's `robots.txt` from the Contensio admin. The file is served dynamically — no server configuration or file system access required.

**Features:**
- Edit robots.txt content in a code-editor–style textarea
- Reset to a sensible default (allow all, include Sitemap URL) at any time
- Served at `/robots.txt` with `Content-Type: text/plain`
- Settings hub card in Admin > Settings
- Stored in the core `settings` table — survives deployments and zero-downtime updates

---

## Requirements

- Contensio 2.0 or later

---

## Installation

### Composer

```bash
composer require contensio/plugin-robots-txt
```

### Manual

Copy the plugin directory and register the service provider via the admin plugin manager.

No migrations required.

---

## Configuration

Go to **Admin > Settings > Robots.txt Editor**.

Write or paste your robots.txt content directly in the textarea. Each directive must be on its own line.

### Default content

When no custom content has been saved, the plugin serves:

```
User-agent: *
Allow: /

Sitemap: https://your-site.com/sitemap.xml
```

The Sitemap URL is generated from your app's `APP_URL` environment variable.

---

## How it works

The plugin registers a public `GET /robots.txt` route at the top of the route stack (before middleware groups). This route reads the stored content from the settings table and returns it as `text/plain`.

If the settings table is unreachable (e.g., during a migration), the default content is served instead.

---

## Hook reference

| Hook | Description |
|------|-------------|
| `contensio/admin/settings-cards` | Settings hub card linking to the editor |

---

## Database storage

| Column | Value |
|--------|-------|
| `module` | `plugin_robots_txt` |
| `setting_key` | `content` |
| `value` | Raw robots.txt string |
