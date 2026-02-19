# Sangu Most Viewed Plugin for OJS 3.4

Plugin generik untuk menampilkan daftar artikel terpopuler (most viewed) di sidebar jurnal OJS 3.4.

## Fitur

- Menampilkan artikel dengan jumlah views terbanyak di sidebar
- Pengaturan periode waktu: 7 hari terakhir, 30 hari terakhir, 1 tahun terakhir, atau sepanjang waktu
- Pengaturan jumlah artikel yang ditampilkan (3, 5, 10, 15, atau 20)
- Mendukung bahasa Inggris dan Indonesia

## Persyaratan

- OJS 3.4.x
- Data statistik kunjungan (tabel `metrics_submission`) harus sudah tersedia

## Instalasi

1. Salin folder `sanguMostViewed` ke direktori `plugins/generic/`
2. Buka **Settings → Website → Plugins**
3. Cari **"Sangu Most Viewed"** di bawah kategori Generic Plugins
4. Klik **Enable**

## Konfigurasi

1. Setelah plugin diaktifkan, klik tombol **Settings** di sebelah nama plugin
2. Pilih **Periode Waktu**:
   - 7 Hari Terakhir
   - 30 Hari Terakhir
   - 1 Tahun Terakhir
   - Sepanjang Waktu *(default)*
3. Pilih **Jumlah Artikel** yang ingin ditampilkan (default: 5)
4. Klik **Save**

## Menampilkan di Sidebar

1. Buka **Settings → Website → Appearance → Sidebar Management**
2. Drag block **"Artikel Terpopuler"** ke area sidebar
3. Block akan otomatis muncul di halaman jurnal

## Struktur File

```
sanguMostViewed/
├── SanguMostViewedPlugin.php          # Plugin utama (GenericPlugin)
├── SanguMostViewedBlockPlugin.php     # Block sidebar (BlockPlugin)
├── SanguMostViewedSettingsForm.php    # Form pengaturan
├── version.xml                        # Metadata plugin
├── README.md
├── templates/
│   ├── block.tpl                      # Template sidebar
│   └── settingsForm.tpl              # Template form pengaturan
└── locale/
    ├── en/
    │   └── locale.po                  # Terjemahan Inggris
    └── id/
        └── locale.po                  # Terjemahan Indonesia
```

## Lisensi

Distributed under the GNU GPL v3. For full terms see the file `docs/COPYING`.
